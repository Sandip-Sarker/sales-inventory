<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name">
                                <label class="form-label">Customer Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email">
                                <label class="form-label">Customer Mobile <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mobile">
                                <label class="form-label">Customer Address</label>
                                <input type="text" class="form-control" id="address">
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
        let name        = document.getElementById('name').value;
        let email       = document.getElementById('email').value;
        let mobile      = document.getElementById('mobile').value;
        let address     = document.getElementById('address').value;

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

            document.getElementById('modal-close').click();
            showLoader();
            let res = await axios.post('/customer-create',{
                name:name,
                email:email,
                mobile:mobile,
                address:address
            });
            hideLoader();

            if(res.data === 1){
                successToast('Customer Create Successfully')
            }else {
                errorToast('Something Went Wrong!');
            }

        }
    }
</script>
