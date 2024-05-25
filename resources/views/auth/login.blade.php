<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Crud</title>


    {{-- ============================== bootstrap style link ==================== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- ============================== google font ============================= --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    {{-- =============================== Fontawesome icon link =================== --}}

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    {{-- =============================== toaster css link ============================= --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- ================================ Datatable cdn css link ===========================  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    @vite(['resources/css/app.css'])
</head>
<body>

{{-- ================================== Login Form Start ========================= --}}
<section class="login-section vh-100 overflow-hidden">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card shadow-lg border-1 cardline">
                    <div class="card-body">
                        <div class="row justify-content-center my-2 gap-2">
                            <h5 class="text-center fw-bold d-md-none loginhead">Sign In</h5>
                            <div class="col-md-10 col-lg-6 col-xl-5">
                                <img src="{{Vite::asset('resources/images/register_image_1.jpg')}}" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-5 form">
                                <h5 class="text-center fw-bold d-none d-md-block loginhead">Sign In</h5>
                                {{-- ============= form start=========== --}}
                                <form action="#" id="loginForm" class="px-4 my-4">
                                    @csrf
                                    <div class="form-group mt-5 ">
                                        <label for="userEmail" class="mb-1">Email<span class="text-danger">*</span></label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-envelope-open-fill"></i></span>
                                            <input type="email" class="form-control" id="userEmail" placeholder="Enter your email" autocomplete ="off">
                                        </div>
                                        <div class="errorMessage" id="emailError"></div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="userPassword" class="mb-1">Password<span class="text-danger">*</span></label>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-unlock-fill"></i></span>
                                            <input type="password" class="form-control" id="userPassword" placeholder="Enter your password" autocomplete ="off">
                                        </div>
                                        <div class="errorMessage" id="passwordError"></div>
                                    </div>
                                    <div class="text-center mt-4 ">
                                        <button type="submit" class="btn loginbtn text-white rounded-1 w-100">Sign In</button>
                                        <p class="mt-3">New user? <a href="{{ route('register') }}" class="text-decoration-none">Sign up here</a></p>
                                    </div>

                                </form>
                                {{-- ============= form end =========== --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

   {{-- ======================= Jquery cdn link ================== --}}
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"
   integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

   {{-- =============================== toaster link====================== --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   {{-- ========================== bootstrap js link ===================== --}}
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

   {{-- ========================== datatable js link  ==================== --}}
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
   @vite(['resources/js/auth.js'])
</body>
</html>




