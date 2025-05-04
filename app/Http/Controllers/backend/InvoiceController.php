<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function dd;
use function view;

class InvoiceController extends Controller
{
    public function SalePage()
    {
        return view('backend.home.sale-page');
    }

    public function invoiceCreate(Request $request)
    {
        DB::beginTransaction();


        try{
            $userId         = $request->header('id');
            $customer_id    = $request->input('customer_id');
            $total          = $request->input('total');
            $discount       = $request->input('discount');
            $vat            = $request->input('vat');
            $payable        = $request->input('payable');

            $invoice = new Invoice();
            $invoice->customer_id   = $customer_id;
            $invoice->user_id       = $userId;
            $invoice->total         = $total;
            $invoice->discount      = $discount;
            $invoice->vat           = $vat;
            $invoice->payable       = $payable;

            $invoice->save();

            $invoiceID = $invoice->id;

            $products  = $request->input('products');

            foreach ($products as $product){
                $invoiceProduct             = new InvoiceProduct();
                $invoiceProduct->invoice_id = $invoiceID;
                $invoiceProduct->user_id    = $userId;
                $invoiceProduct->product_id = $product['product_id'];
                $invoiceProduct->qty        = $product['product_qty'];
                $invoiceProduct->sale_price = $product['product_total_price'];
                $invoiceProduct->save();
            }

            DB::commit();

            return 1;

        }catch (Exception $e){
            DB::rollBack();
            return 0;
        }


    }

    public function invoicePage()
    {
        return view('backend.home.invoice-page');
    }

    public function invoiceList(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
       try{
           $user_id = $request->header('id');
           InvoiceProduct::where('invoice_id', $request->input('invId'))->where('user_id', $user_id)->delete();
           Invoice::where('id', $request->input('invId'))->where('user_id', $user_id)->delete();
           DB::commit();
           return 1;
       }catch (Exception $e){
           DB::rollBack();
           return 0;
       }
    }

    public function InvoiceDetails(Request $request)
    {
        $user_id = $request->header('id');
        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->input('cus_id'))->first();
        $invoiceTotal = Invoice::where('user_id', $user_id)->where('id', $request->input('inv_id'))->first();
        $invoiceProduct =  InvoiceProduct::where('user_id', $user_id)->where('invoice_id', $request->input('inv_id'))->with('product')->get();

        return array(
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct
        );
    }
}


