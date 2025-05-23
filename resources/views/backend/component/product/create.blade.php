<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnit">

                                <label class="form-label mt-2">Description</label>
                                <input type="text" class="form-control" id="productDescription">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>

    {{-- Product Category start here   --}}
    FillCategoryDropdown()

    async function FillCategoryDropdown() {

        let res = await axios.get('/category-list')

        res.data.forEach(function (item, index) {

            let option = `<option value="${item.id}">${item.name}</option>`

            $('#productCategory').append(option);
        })

    }
    {{-- Product Category End here   --}}

    {{-- Product Create start   --}}
    async function Save() {

        let productCategory     = document.getElementById('productCategory').value;
        let productName         = document.getElementById('productName').value;
        let productPrice        = document.getElementById('productPrice').value;
        let productUnit         = document.getElementById('productUnit').value;
        let productDescription  = document.getElementById('productDescription').value;
        let productImg          = document.getElementById('productImg').files[0];

        if (productCategory.length === 0){
            errorToast('Product Category Required !')
        }else if (productName.length === 0){
            errorToast('Product Name Required !')
        }else if (productPrice.length === 0){
            errorToast('Product Price Required !')
        }else if (productUnit.length === 0){
            errorToast('Product Unit Required !')
        }else if (!productImg){
            errorToast('Product Image Required !')
        }else {
            document.getElementById('modal-close').click();

            let fromData = new FormData();
            fromData.append('image', productImg)
            fromData.append('name', productName)
            fromData.append('price', productPrice)
            fromData.append('unit', productUnit)
            fromData.append('description', productDescription)
            fromData.append('category_id', productCategory)

            const config = {
                header: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post('/product-create', fromData,config)
            hideLoader()

            if (res.data === 1){
                successToast('Product Create Successfully');
                document.getElementById('save-form').reset();
                await getList();
            }else{
                errorToast('Something is Wrong !')
            }
        }

    }

</script>
