<script src="{{asset('js/appgeneral.min.js')}}"></script>
<script src="{{asset('js/eshopper.min.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/jquery.mlens-1.7.min.js')}}"></script>
<script src="{{asset('js/funcionalidad.js')}}"></script>

<!--
<script src="{{asset('js/all.min.js')}}"></script>
<script src="{{asset('js/brands.min.js')}}"></script>
<script src="{{asset('js/fontawesome.min.js')}}"></script>
<script src="{{asset('js/solid.min.js')}}"></script>
-->
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

<script>
    lazyload();
    window.oncontextmenu = function() {
        return false;
    }

    $('#recipeCarousel').carousel({
        interval: 10000
    })

    $('.carousel .carousel-item').each(function(){
        var minPerSlide = 3;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));
        
        for (var i=0;i<minPerSlide;i++) {
            next=next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            
            next.children(':first-child').clone().appendTo($(this));
        }
    });

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

    $(document).ready(function()
    {
        $("#image_zoom").mlens(
        {
            imgSrc: $("#image_zoom").attr("data-big"),   // path of the hi-res version of the image
            lensShape: "circle",                // shape of the lens (circle/square)
            lensSize: 125,                  // size of the lens (in px)
            borderSize: 4,                  // size of the lens border (in px)
            borderColor: "#fff",                // color of the lens border (#hex)
            borderRadius: 4,                // border radius (optional, only if the shape is square)
            zoomLevel: 2,
            imgOverlay: $("#image_zoom").attr("data-overlay"), // path of the overlay image (optional)
            overlayAdapt: true // true if the overlay image has to adapt to the lens size (true/false)
        });
    });

    var cambiar_imagen = document.querySelectorAll("div.item > img.cambiar_imagen");
    for (unHijo of cambiar_imagen) {
        unHijo.addEventListener("click", function(evt){
            var src = evt.target.src;
            var alt = evt.target.alt;
            document.getElementById("cambiar_principal").innerHTML = "";
            document.getElementById('cambiar_principal').innerHTML = '<img id="image_zoom" src="'+src+'" alt="'+alt+'"/>';

            $(document).ready(function()
            {
                $("#image_zoom").mlens(
                {
                    imgSrc: $("#image_zoom").attr("data-big"),   // path of the hi-res version of the image
                    lensShape: "circle",                // shape of the lens (circle/square)
                    lensSize: 125,                  // size of the lens (in px)
                    borderSize: 4,                  // size of the lens border (in px)
                    borderColor: "#fff",                // color of the lens border (#hex)
                    borderRadius: 4,                // border radius (optional, only if the shape is square)
                    zoomLevel: 2,
                    imgOverlay: $("#image_zoom").attr("data-overlay"), // path of the overlay image (optional)
                    overlayAdapt: true // true if the overlay image has to adapt to the lens size (true/false)
                });
            });
        });
    }
</script>
