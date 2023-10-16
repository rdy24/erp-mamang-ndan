<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="shortcut icon" href={{ asset("assets/img/stisla-fill.svg") }} type="image/x-icon">
  <title>@yield('title')</title>

  <!-- General CSS Files -->
  @include('includes.style')

  <!-- CSS Libraries -->
  @stack('css-libraries')


  <!-- Template CSS -->
  <link rel="stylesheet" href={{ asset("assets/css/style.css") }}>
  <link rel="stylesheet" href={{ asset("assets/css/components.css") }}>

  {{-- jquery --}}
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      @include('components.navbar')

      @include('components.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @include('sweetalert::alert')
          @yield('content')
        </section>
      </div>
      @include('components.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  @include('includes.script')

  <!-- JS Libraies -->
  @stack('js-libraries')

  <!-- Template JS File -->
  <script src={{ asset("assets/js/scripts.js") }}></script>
  <script src={{ asset("assets/js/custom.js") }}></script>

  <!-- Page Specific JS File -->
  @stack('js-page')

  <!-- Confirm Box -->
  @stack('alert-js')
</body>

</html>