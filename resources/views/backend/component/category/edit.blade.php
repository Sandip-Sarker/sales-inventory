<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>

    async function fillUpForm(id){
        document.getElementById('updateID').value=id;
        showLoader()
        let res = await axios.post('/category-edit', {'id':id})
        hideLoader()

        document.getElementById('categoryNameUpdate').value=res.data['name'];
    }


    async function Update() {
        let name    = document.getElementById('categoryNameUpdate').value;
        let id      = document.getElementById('updateID').value;


        if(name.length === 0)
        {
            errorToast('Category Name is Required')
        }else {
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post('/category-update', {id:id , name:name})
            hideLoader();

            if (res.data === 1 && res.status === 200)
            {
                successToast('Category Update Successfully')
                await getList();
            }else {
                errorToast('Something is Wrong!')
            }
        }
    }
</script>
