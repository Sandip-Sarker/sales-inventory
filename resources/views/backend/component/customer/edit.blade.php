<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label"> Name *</label>
                                <input type="text" class="form-control" id="nameUpdate">

                                <label class="form-label mt-3"> Email *</label>
                                <input type="text" class="form-control" id="emailUpdate">

                                <label class="form-label mt-3"> Mobile *</label>
                                <input type="text" class="form-control" id="mobileUpdate">

                                <label class="form-label mt-3">Address*</label>
                                <input type="text" class="form-control" id="addressUpdate">

                                <input type="text" class="d-none" id="updateID">
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

    async function fillUpForm(id) {
        document.getElementById('updateID').value=id;
        showLoader()
        let res = await axios.post('/customer-edit', {'id':id})
        hideLoader()
        console.log(res);
        document.getElementById('nameUpdate').value     = res.data['name'];
        document.getElementById('emailUpdate').value    = res.data['email'];
        document.getElementById('mobileUpdate').value   = res.data['mobile'];
        document.getElementById('addressUpdate').value  = res.data['address'];
    }

    async function Update() {
        let name        = document.getElementById('nameUpdate').value;
        let email       = document.getElementById('emailUpdate').value;
        let mobile      = document.getElementById('mobileUpdate').value;
        let address     = document.getElementById('addressUpdate').value;
        let id          = document.getElementById('updateID').value;


        let mobileValidate = /^[0-9]{11}$/;
        let emailValidate = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name.length === 0) {
            errorToast('Name is required');
        } else if (email.length === 0) {
            errorToast('Email is required');
        } else if (!emailValidate.test(email)) {
            errorToast('Email format is invalid');
        } else if (mobile.length === 0) {
            errorToast('Mobile is required');
        } else if (!mobileValidate.test(mobile)) {
            errorToast('Mobile number must be 11 digits only');
        } else {

            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post('/customer-update',{
                id:id,
                name:name,
                email:email,
                mobile:mobile,
                address:address
            });
            hideLoader();

            if(res.data === 1){
                successToast('Customer Update Successfully')
                document.getElementById('update-form').reset();
                await getList();
            }else {
                errorToast('Something Went Wrong!');
            }

        }
    }
</script>
