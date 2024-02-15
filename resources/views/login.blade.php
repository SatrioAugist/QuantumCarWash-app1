<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QCW</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- End layout styles -->
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-center p-5">
                <div class="brand-logo">
                  <img src="/images/logo_qcw.png">
                </div>
                <div class="text-left"> <!-- Tambahkan class text-left untuk membuat teks berada di sebelah kiri -->
                  <h4 >Hai, Selamat Datang!</h4>
                  <h6 class="font-weight-light">Silahkan Login Terlebih Dahulu</h6>
                </div> 
                @if(session('success'))
                  <p class="alert alert-success">{{ session('success') }}</p>
                @endif
                @if($errors->any())
                  @foreach($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                  @endforeach
                @endif
                <form class="pt-3" action="{{route('login.action')}}" method="post">
                  @csrf
                  <div class="form-group">
                    <input name="username" value="{{old('username')}}" type="text" class="form-control" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Masuk</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('js/off-canvas.js')}}"></script>
    <script src="{{asset('js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('js/misc.js')}}"></script>
    <!-- endinject -->
  </body>
</html>
