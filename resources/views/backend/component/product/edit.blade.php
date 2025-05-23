<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">

                                <label class="form-label mt-2">Description</label>
                                <textarea type="text" class="form-control" id="productDescriptionUpdate"></textarea>
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>

        </div>
    </div>
</div>


<script>

    async function UpdateFillCategoryDropdown() {

        let res = await axios.get('/category-list')

        res.data.forEach(function (item, index) {

            let option = `<option value="${item.id}">${item.name}</option>`

            $('#productCategoryUpdate').append(option);
        })

    }

    async function fillUpForm(id,filePath) {
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;

        showLoader()
        UpdateFillCategoryDropdown();
        let res = await axios.post('/product-edit', {'id':id})
        hideLoader()


        document.getElementById('productNameUpdate').value          = res.data['name'];
        document.getElementById('productPriceUpdate').value         = res.data['price'];
        document.getElementById('productUnitUpdate').value          = res.data['unit'];
        document.getElementById('productDescriptionUpdate').value   = res.data['description'];
        document.getElementById('productCategoryUpdate').value      = res.data['category_id'];
    }

    async function update() {

        let productCategoryUpdate     = document.getElementById('productCategoryUpdate').value;
        let productNameUpdate         = document.getElementById('productNameUpdate').value;
        let productPriceUpdate        = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate         = document.getElementById('productUnitUpdate').value;
        let productDescriptionUpdate  = document.getElementById('productDescriptionUpdate').value;
        let productImgUpdate          = document.getElementById('productImgUpdate').files[0];
        let updateID                  =document.getElementById('updateID').value;
        let filePath                  =document.getElementById('filePath').value;

        if (productCategoryUpdate.length === 0){
            errorToast('Product Category Required !')
        }else if (productNameUpdate.length === 0){
            errorToast('Product Name Required !')
        }else if (productPriceUpdate.length === 0){
            errorToast('Product Price Required !')
        }else if (productUnitUpdate.length === 0){
            errorToast('Product Unit Required !')
        }else {
            document.getElementById('update-modal-close').click();

            let fromData = new FormData();
            fromData.append('id',updateID)
            fromData.append('category_id', productCategoryUpdate)
            fromData.append('image', productImgUpdate)
            fromData.append('name', productNameUpdate)
            fromData.append('price', productPriceUpdate)
            fromData.append('unit', productUnitUpdate)
            fromData.append('description', productDescriptionUpdate)
            fromData.append('file_path',filePath)

            const config = {
                header: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post('/product-update', fromData,config)
            hideLoader()

            if (res.data === 1){
                successToast('Product Update Successfully');
                document.getElementById('update-form').reset();
                await getList();
            }else{
                errorToast('Something is Wrong !')
            }
        }

    }
</script>
