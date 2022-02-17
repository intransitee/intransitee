<!DOCTYPE html>

<html
lang="en"
class="dark-style customizer-hide"
dir="ltr"
data-theme="theme-default"
data-assets-path="{{asset('admin/assets/')}}/"
data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login Intransitee</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('logo/Logo2.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('admin/assets/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
          <div class="flex-row text-center mx-auto">
            {{-- <img
              src="{{asset('admin/assets/img/pages/login-light.png')}}"
              alt="Auth Cover Bg color"
              width="520"
              class="img-fluid authentication-cover-img"
              data-app-light-img="{{asset('admin/assets/img/pages/login-light.png')}}"
              data-app-dark-img="{{asset('admin/assets/img/pages/login-dark.png')}}"
            /> --}}
            <img src="{{asset('logo/Logo2.png')}}" alt="Auth Cover Bg color" width="200" class="img-fluid authentication-cover-img"
            data-app-light-img="{{asset('admin/assets/img/pages/login-light.png')}}"
              data-app-dark-img="{{asset('admin/assets/img/pages/login-dark.png')}}">
            <div class="mx-auto">
              <h3>Think of City Courier Think of intransitee.id</h3>
              <p>
                We Help Your Business stand out in the market and conquer your buyers heart with any customize solution<br />
                To ensure that we build a simple and useful Delivery service in Indonesia
              </p>
            </div>
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="authentication-bg d-flex col-12 col-lg-5 col-xl-4 align-items-center p-4 p-sm-5">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
              <a href="index.html" class="app-brand-link gap-2 mb-2">
                <img src="{{asset('logo/LogoText2.png')}}" width="250" height="auto" alt="">
              </a>
            </div>
            <!-- /Logo -->
            {{-- <h4 class="mb-2">Welcome to Frest! 👋</h4> --}}
            <p class="mb-4">Please sign-in to your account.</p>

            <form id="login" class="mb-3" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email or Username</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email-username"
                  placeholder="Enter your email or username"
                  autofocus
                />
              </div>
              <div class="form-password-toggle mb-3">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="auth-forgot-password-cover.html">
                    <small>Forgot Password?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" checked/>
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
              </div>
              <button type="button" class="btn btn-primary d-grid w-100 validasi" onclick="login()">Sign in</button>
            </form>

            {{-- <p class="text-center">
              <span>New on our platform?</span>
              <a href="auth-register-cover.html">
                <span>Create an account</span>
              </a>
            </p>

            <div class="divider my-4">
              <div class="divider-text">or</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons bx bxl-facebook"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons bx bxl-google-plus"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons bx bxl-twitter"></i>
              </a>
            </div> --}}
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

    <script type="text/javascript">
        function login(item){
        var	email = $('#email').val();
        var	password = $('#password').val();

        console.log(email)
        console.log(password)

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/checkAuth')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { email:email, password:password },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);
            console.log(obj)

            if (obj.status == true) {
                $("#login")[0].reset();
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('dashboard') }}';
            } else {
                $("#login")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

    </script>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('admin/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>

    <script src="{{asset('admin/assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

    <!-- Main JS -->
    {{-- <script src="{{asset('admin/assets/js/main.js')}}"></script> --}}

    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/pages-auth.js')}}"></script>
  </body>
</html>
