<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<script>

    async function Save() {

        let name = document.getElementById('name').value;

        if(name.length === 0)
        {
            errorToast('Category Name is Required')
        }else {
            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post('/category-create', {name:name})
            hideLoader();

            if (res.status === 200 && res.data.status === 'success')
            {
                successToast('User Registration Successfully');
                document.getElementById('save-form').reset();

                await getList();
            }
            else
            {
                errorToast('Something Went Wrong');
            }
        }


    }

</script>
