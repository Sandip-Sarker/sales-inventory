@extends('frontend.master')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 center-screen">
                <div class="card animated fadeIn w-100 p-3">
                    <div class="card-body">
                        <h4>Sign Up</h4>
                        <hr/>
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <label>First Name</label>
                                    <input id="first_name" placeholder="First Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Last Name</label>
                                    <input id="last_name" placeholder="Last Name" class="form-control" type="text"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Mobile Number</label>
                                    <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Email Address</label>
                                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label>Password</label>
                                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                                </div>
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button onclick="SubmitRegister()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        async function SubmitRegister() {
            let first_name      =document.getElementById('first_name').value;
            let last_name       =document.getElementById('last_name').value;
            let mobile          =document.getElementById('mobile').value;
            let email           =document.getElementById('email').value;
            let password        =document.getElementById('password').value;

            if(first_name.length === 0)
            {
                errorToast("First Name is requierd")
            }else if(last_name.length === 0){
                errorToast("Last Name is requierd")
            }else if(mobile.length === 0){
                errorToast("Phone Number is requierd")
            }else if(email.length === 0){
                errorToast("Email is requierd")
            }else if(password.length === 0){
                errorToast("Password is requierd")
            }else{
                showLoader();
                let res = await axios.post('/user-registrations', {
                    first_name:first_name,
                    last_name:last_name,
                    mobile:mobile,
                    email:email,
                    password:password
                });
                hideLoader();

                if(res.status === 200 && res.data.status === 'success'){
                    successToast(res.data.message)
                    setTimeout(function () {
                        window.location.href='/login';
                    }, 2000)

                }else{
                    errorToast(res.data.message);
                }
            }

        }

    </script>

@endsection
