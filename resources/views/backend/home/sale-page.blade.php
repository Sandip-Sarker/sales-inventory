@extends('backend.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Billing  -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <div class="row">
                        <div class="col-8">
                            <span class="text-bold text-dark">BILLED TO </span>
                            <p class="text-xs mx-0 my-1">Name:  <span id="CName"></span> </p>
                            <p class="text-xs mx-0 my-1">Email:  <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1">User ID:  <span id="CId"></span> </p>
                        </div>
                        <div class="col-4">
                            <img class="w-50" src="{{"images/logo.png"}}">
                            <p class="text-bold mx-0 my-1 text-dark">Invoice  </p>
                            <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    <div class="row">
                        <div class="col-12">
                            <table class="table w-100" id="invoiceTable">
                                <thead class="w-100">
                                <tr class="text-xs">
                                    <td>Name</td>
                                    <td>Qty</td>
                                    <td>Total</td>
                                    <td>Remove</td>
                                </tr>
                                </thead>
                                <tbody  class="w-100" id="invoiceList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i> <span id="total"></span></p>
                            <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>  <span id="payable"></span></p>
                            <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>  <span id="vat"></span></p>
                            <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>  <span id="discount"></span></p>
                            <span class="text-xxs">Discount(%):</span>
                            <input onkeydown="return false" value="0" min="0" type="number" step="0.25" onchange="DiscountChange()" class="form-control w-40 " id="discountPercentage"/>
                            <p>
                                <button onclick="createInvoice()" class="btn  my-3 bg-gradient-primary w-40">Confirm</button>
                            </p>
                        </div>
                        <div class="col-12 p-2">

                        </div>

                    </div>
                </div>
            </div>

            <!-- Product  -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table  w-100" id="productTable">
                        <thead class="w-100">
                        <tr class="text-xs text-bold">
                            <td>Product</td>
                            <td>Price</td>
                            <td>Pick</td>
                        </tr>
                        </thead>
                        <tbody  class="w-100" id="productList">

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customer  -->
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table table-sm w-100" id="customerTable">
                        <thead class="w-100">
                        <tr class="text-xs text-bold">
                            <td>Customer</td>
                            <td>Pick</td>
                        </tr>
                        </thead>
                        <tbody  class="w-100" id="customerList">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p-1">
                                    <label class="form-label">Product ID *</label>
                                    <input type="text" class="form-control" id="PId">
                                    <label class="form-label mt-2">Product Name *</label>
                                    <input type="text" class="form-control" id="PName">
                                    <label class="form-label mt-2">Product Price *</label>
                                    <input type="text" class="form-control" id="PPrice">
                                    <label class="form-label mt-2">Product Qty *</label>
                                    <input type="text" class="form-control" id="PQty">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="add()" id="save-btn" class="btn bg-gradient-success" >Add</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        //Function Calling
        (async ()=>{
            showLoader()
             await customerList();
             await productList();
            hideLoader()
        })()

        //Customer List
        async function customerList() {
            let customerList    = $("#customerList");
            let customerTable   = $("#customerTable");
            let res             = await axios.get('/customer-list');
            customerTable.DataTable().destroy();
            customerList.empty();

            res.data.forEach(function (item,index) {
                let row = `<tr class="text-xs">
                        <td><i class="bi bi-person"></i> ${item.name}</td>
                        <td>
                            <a data-name="${item.name}" data-email="${item.email}" data-id="${item.id}"
                            class="btn btn-outline-dark addCustomer  text-xxs px-2 py-1  btn-sm m-0">Add</a>
                        </td>
                    </tr>`

                customerList.append(row);

            })

            // add customer to billing
            $(".addCustomer").on('click',async function () {
                let name = $(this).data('name');
                let email = $(this).data('email');
                let id = $(this).data('id');

                $('#CName').text(name);
                $('#CEmail').text(email);
                $('#CId').text(id);
            });

            new DataTable('#customerTable',{
                    order:[[0,'desc']],
                    scrollCollapse: false, //// যখন কম সারি দেখানো হবে তখন টেবিলের উচ্চতা যেন কমে না যায়, সেটি নির্ধারণ করে
                    info: false, //Hide Showing 1 to 10 of 50 entries
                    lengthChange: false //ব্যবহারকারী যেন প্রতি পাতায় কয়টা রো দেখবে (10, 25, 50 etc.) সেটি পরিবর্তন করতে না পারে। ড্রপডাউনটি হাইড থাকবে।
                });
        }

        // Product List
        async function productList() {
            let productList     = $("#productList");
            let productTable    = $("#productTable");
            let res             = await axios.get('/product-list');
            productTable.DataTable().destroy();
            productList.empty();

            res.data.forEach(function (item, index) {
                let row = `<tr class="text-xs">
                        <td><img class="w-10" src="${item.image}"/> ${item.name}</td>
                        <td>${item.price}</td>
                        <td>
                            <a data-id="${item.id}" data-name="${item.name}" data-price="${item.price}"
                            class="btn btn-outline-dark addProduct  text-xxs px-2 py-1  btn-sm m-0">Add</a>
                        </td>
                    </tr>`

                productList.append(row);
            })

            $('.addProduct').on('click', async function () {
                let id      = $(this).data('id');
                let name    = $(this).data('name');
                let price   = $(this).data('price');
                addModal(id, name, price);
            })

            new DataTable('#productTable',{
                order:[[0,'desc']],
                scrollCollapse: false, //// যখন কম সারি দেখানো হবে তখন টেবিলের উচ্চতা যেন কমে না যায়, সেটি নির্ধারণ করে
                info: false, //Hide Showing 1 to 10 of 50 entries
                lengthChange: false //ব্যবহারকারী যেন প্রতি পাতায় কয়টা রো দেখবে (10, 25, 50 etc.) সেটি পরিবর্তন করতে না পারে। ড্রপডাউনটি হাইড থাকবে।

            });
        }

        // Modal product data add
        function addModal(id, name, price){
            $('#PId').val(id);
            $('#PName').val(name);
            $('#PPrice').val(price);
            $('#create-modal').modal('show')
        }

        let invoiceItemList = [];

        //Billing product data push
        function add() {
            let id      =  $('#PId').val();
            let name    =  $('#PName').val();
            let price   =  $('#PPrice').val();
            let qty     =  $('#PQty').val();
            let total   =  (parseFloat(price)*parseFloat(qty)).toFixed(2);

            if(name.length === 0){
                errorToast('Name is required')
            }else if(price.length === 0) {
                errorToast('Price is required')
            }else if(qty.length === 0) {
                errorToast('Quantity is required')
            }else {
                let item = {
                    product_id:id,
                    product_name:name,
                    product_sale_price:price,
                    product_qty:qty,
                    product_total_price:total
                }
                invoiceItemList.push(item);
                $('#create-modal').modal('hide')
                ShowInvoiceItem();
            }
        }

        //Billing data add
        function ShowInvoiceItem() {
            let invoiceList = $('#invoiceList');

            invoiceList.empty();

            invoiceItemList.forEach(function (item, index) {
                let row = `<tr>
                                <td>${item['product_name']}</td>
                                <td>${item['product_qty']}</td>
                                <td>${item['product_total_price']}</td>
                                <td><a data-index="${index}" class="btn remove text-xxs px-2 py-1  btn-sm m-0">Remove</a></td>
                           </tr>`
                invoiceList.append(row);
            })

            CalculateGrandTotal();

            $('.remove').on('click', async function () {
                let index= $(this).data('index');
                removeItem(index);
            })
        }

        //Remove item
        function removeItem(index) {
            invoiceItemList.splice(index,1);
            ShowInvoiceItem()
        }

        // All total count
        function CalculateGrandTotal() {
            let Total               = 0;
            let Vat                 = 0;
            let Payable             = 0;
            let Discount            = 0;
            let discountPercentage  = (parseFloat(document.getElementById('discountPercentage').value));

            invoiceItemList.forEach(function (item, index) {
                Total = Total + parseFloat(item.product_total_price)
                console.log(Total)
            })

            if (discountPercentage === 0){
                Vat =  ((Total*5)/100).toFixed(2);

                console.log(Vat)
            }else{
                Discount    = ((Total*discountPercentage)/100).toFixed(2);
                Total       = (Total - ((Total*discountPercentage)/100)).toFixed(2);
                Vat         = ((Total*5)/100).toFixed(2);
                console.log(Vat)
            }

            Payable = (parseFloat(Total) + parseFloat(Vat)).toFixed(2);

            $('#total').text(Total);
            $('#payable').text(Payable);
            $('#vat').text(Vat);
            $('#discount').text(Discount);

        }

        //Discount change
        function DiscountChange() {
            CalculateGrandTotal();
        }

        //Invoice Create
        async function createInvoice() {
            let total       = $('#total').text();
            let payable     = $('#payable').text();
            let vat         = $('#vat').text();
            let discount    = $('#discount').text();
            let customerId  = $('#CId').text();

            let Data = {
                "total":total,
                "payable":payable,
                "vat":vat,
                "discount":discount,
                "customer_id":customerId,
                "products":invoiceItemList
            }

            if (customerId.length === 0){
                errorToast("Customer Required !")
            }else if(invoiceItemList.length === 0){
                errorToast("Product Required !")
            }else {
                showLoader()
                let res = await axios.post('/invoice-create', Data)
                hideLoader()
                if(res.data === 1){
                    window.location.href='/invoice-page'
                    successToast("Invoice Created");
                }
                else{
                    errorToast("Something Went Wrong")
                }
            }
        }
    </script>
@endsection


