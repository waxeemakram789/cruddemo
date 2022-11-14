<html>
    <head>
        @include('header')
        
        <!-- Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        @stack('styles')
    </head>
    <body>
        @yield('content')
        {{-- @include('footer') --}}
        <!-- Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @stack('scripts')
        <script>
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error('{{$error}}');
                @endforeach
            @endif
          </script>
          <script>
            $(document).ready(function() {
                @if (Session::has('success'))
                  toastr.success(`{{ Session::pull('success') }}`);
                    // Toaster.fire({
                    // icon: 'success',
                    // title: "{{ Session::pull('success') }}"
                    // });
                @elseif( Session::has('error') )
                    toastr.error(`{{ Session::pull('error') }}`);
                    // Toaster.fire({
                    // icon: 'error',
                    // title: "{{ Session::pull('error') }}"
                    // });
                @elseif( Session::has('info') )
                  toastr.info(`{{ Session::pull('info') }}`;)
                    // Toaster.fire({
                    // icon: 'info',
                    // title: "{{ Session::pull('info') }}"
                    // });
                @elseif( Session::has('warning') )
                  toastr.warning(`{{ Session::pull('warning') }}`);
                    // Toaster.fire({
                    // icon: 'info',
                    // title: "{{ Session::pull('info') }}"
                    // });
                @endif
            
            });
          </script>
    </body>
</html>






