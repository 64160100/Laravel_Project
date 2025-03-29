<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ระบบติดตามแผนงาน | Lib Buu</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('Bootslander/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('Bootslander/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('Bootslander/assets/vendor/aos/aos.css" rel="stylesheet')}}">
    <link href="{{asset('Bootslander/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('Bootslander/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{asset('Bootslander/assets/css/main.css')}}" rel="stylesheet">
</head>

<body class="index-page">

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <!-- <img src="{{asset('images/lib_buu.png')}}" class="img-fluid animated" alt=""> -->
                        <img src="{{asset('images/loginpages.png')}}" class="img-fluid " alt="">
                    </div>
    
                    <div class="col-lg-6 d-flex flex-column justify-content-center order-lg-last" data-aos="fade-in">
                        <div class='card p-4 custom-bg'>
                            <h1 class="text-center">ระบบติดตามแผนงาน</h1>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group mb-3 position-relative">
                                    <label for="username" class="form-label">ชื่อผู้ใช้</label>
                                    <input id="username" class="form-control" placeholder="กรุณาใส่ชื่อผู้ใช้"
                                        name="username" required>
                                </div>

                                <div class="form-group mb-3 position-relative">
                                    <label for="password" class="form-label">รหัสผ่าน</label>
                                    <input id="password" type="password" class="form-control"
                                        style="border: 1px solid #ccc;" placeholder="กรุณาใส่รหัสผ่าน" name="password"
                                        required>
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="text-center">
                                    <button type="submit" class='btn btn-warning mt-4'>เข้าสู่ระบบ</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- Vendor JS Files -->
    <script src="{{asset('Bootslander/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('Bootslander/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('Bootslander/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('Bootslander/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('Bootslander/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{asset('Bootslander/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

</body>

</html>