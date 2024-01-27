<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>QCW</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset ('vendors/css/vendor.bundle.base.css')}}">


  <!-- datatable -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />



</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{asset ('images/qcw_mini.png')}}"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset ('images/logo-mini.svg') }}"
            alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
              aria-expanded="false">
              <div class="nav-profile-text">
                <p class="mb-1 text-black">{{ Auth::user()->nama}}</p>
              </div>
            </a>

            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              @if (in_array(Auth::user()->role, ['owner']))
              <a class="dropdown-item" href="{{ url('log') }}">
                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
              @endif
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" class="nav-link" id="logout-button" onclick="confirmLogout()">
                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
            </div>
          </li>

          <script>
            function confirmLogout() {
              var confirmation = confirm('Are you sure you want to log out?');
              if (confirmation) {
                // Redirect to the logout URL only if the user confirms.
                window.location.href = "{{ url('logout') }}";
              } else {
                // If the user cancels the logout, do nothing.
              }
            }
          </script>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="{{asset('images/faces/face1.jpg')}}" alt="profile">
                <span class="login-status online"></span>
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{ Auth::user()->nama}}</span>
                <span class="text-secondary text-small">{{ Auth::user()->role}}</span>
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>

          @if (in_array(Auth::user()->role, ['admin']))
          <li class="nav-item">
            <a class="nav-link" href="{{ url('paket') }}">
              <span class="menu-title">Paket</span>
              <i class="mdi mdi-car-wash menu-icon"></i>
            </a>
          </li>
          @endif

          @if (in_array(Auth::user()->role, ['kasir','owner','admin']))
          <li class="nav-item">
            <a class="nav-link" href="{{ url('transactions') }}">
              <span class="menu-title">Transaksi</span>
              <i class="mdi mdi-swap-horizontal menu-icon"></i>
            </a>
          </li>
          @endif

          @if (in_array(Auth::user()->role, ['admin']))
          <li class="nav-item">
            <a class="nav-link" href="{{ url('users') }}">
              <span class="menu-title">Pengguna</span>
              <i class="mdi mdi-account  menu-icon"></i>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')


        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
              satrioaugist@gamail.com 2024</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> @satrioaugist</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <script>
    function calculateTotal() {
      // Ambil nilai qty
      var qty = document.getElementById('qty').value;

      // Ambil harga produk dari dropdown
      var id_produk = document.getElementsByName('id_produk')[0];
      var harga_produk = id_produk.options[id_produk.selectedIndex].text.split(' - ')[1];

      // Hitung total harga
      var total_harga = qty * harga_produk;

      // Tampilkan total harga di input total_harga
      document.getElementById('total_harga').value = total_harga;
    }
  </script>
  <!-- datatable -->


  <!-- plugins:js -->
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset('vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('js/jquery.cookie.js" type="text/javascript')}}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset ('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset ('js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="{{asset ('js/dashboard.js') }}"></script>
  <script src="{{asset ('js/todolist.js') }}"></script>
  <!-- End custom js for this page -->
</body>

</html>