<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use function date;
use function strtotime;
use function view;

class ReportController extends Controller
{
    public function reportPage()
    {
        return view('backend.home.report-page');
    }
    public function salesReport(Request $request)
    {
        $user_id    = $request->header('id');
        $FormDate   = date('Y-m-d', strtotime($request->formDate));
        $ToDate     = date('Y-m-d', strtotime($request->toDate));

        $total      =Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat        =Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable    =Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount   =Invoice::where('user_id',$user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');



        $list       =Invoice::where('user_id',$user_id)
                    ->whereDate('created_at', '>=', $FormDate)
                    ->whereDate('created_at', '<=', $ToDate)
                    ->with('customer')->get();

        $data=[
            'payable'=> $payable,
            'discount'=>$discount,
            'total'=> $total,
            'vat'=> $vat,
            'list'=>$list,
            'FormDate'=>$request->formDate,
            'ToDate'=>$request->toDate
        ];
        $pdf = Pdf::loadView('backend.report.sales-report',$data);


        return $pdf->download('invoice.pdf');
    }
}
