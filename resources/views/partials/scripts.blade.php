<script src="{{asset('js/appgeneral.min.js')}}"></script>
<script src="{{asset('js/eshopper.min.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<!--
<script src="{{asset('js/all.min.js')}}"></script>
<script src="{{asset('js/brands.min.js')}}"></script>
<script src="{{asset('js/fontawesome.min.js')}}"></script>
<script src="{{asset('js/solid.min.js')}}"></script>
-->
<script>
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif

  @if(count($errors) > 0)
    toastr.error("@foreach($errors->all() as $error)"+
                    "<p>{{$error}}</p>"+
                 "@endforeach");
  @endif
</script>
