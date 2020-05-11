@extends('layouts.master')
@section('title', 'Contacto')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="jumbotron text-center">
                    <div id="map-canvas" style="height: 425px; width: 100%; position: relative; overflow: hidden;"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <blockquote class="blockquote">
                    <p>Teléfonos ({{ $contacto->phones->count() }})</p>

                    @foreach ($contacto->phones as $item)
                        <footer class="blockquote-footer">
                            <span><i class="fa fa-phone"></i> {{ $item->phone }}</span>
                        </footer>
                    @endforeach
                </blockquote>
            </div>
            <div class="col-sm-5">
                <blockquote class="blockquote">
                    <p>Direcciones ({{ $contacto->addresses->count() }})</p>

                    @foreach ($contacto->addresses as $item)
                        <footer class="blockquote-footer">
                            <span><i class="fa fa-direction"></i> {{ $item->direction }}</span>
                        </footer>
                    @endforeach
                </blockquote>
            </div>
            <div class="col-sm-4">
                <blockquote class="blockquote">
                    <p>Siguenos en redes sociales</p>
                    <footer class="blockquote-footer">
                        <span><i class="fa fa-facebook"></i> {{ $contacto->facebook }}</span>
                    </footer>
                    <footer class="blockquote-footer">
                        <span><i class="fa fa-twitter"></i> {{ $contacto->twitter }}</span>
                    </footer>
                    <footer class="blockquote-footer">
                        <span><i class="fa fa-instagram"></i> {{ $contacto->instagram }}</span>
                    </footer>
                    <footer class="blockquote-footer">
                        <span><i class="fa fa-laptop"></i> {{ $contacto->page }}</span>
                    </footer>
                </blockquote>
            </div>
        </div>
        <br>
        <br>
        <hr>
    </div>
</section>

@endsection
@section('scripts')
<script type='text/javascript' src='https://maps.google.com/maps/api/js?language=es&key={{ env('GOOGLE_MAPS_API_KEY') }}'></script>
<script defer>
    const empresa = {!! json_encode($contacto->name) !!};
    const longitud = {!! json_encode($contacto->ubication_x) !!};
    const latitud = {!! json_encode($contacto->ubication_y) !!};
    const logotipo = {!! json_encode($contacto->logotipo) !!};
    const direccion = {!! json_encode($contacto->addresses->take(1)) !!};
    const telefono = {!! json_encode($contacto->phones->take(1)) !!};

	function initialize() {
		var mapOptions = {
			zoom: 6,
			minZoom: 6,
			maxZoom: 17,
			zoomControl:true,
			zoomControlOptions: {
  				style:google.maps.ZoomControlStyle.DEFAULT
			},
			center: new google.maps.LatLng(15.7834711, -90.2307587),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			panControl:false,
			mapTypeControl:false,
			scaleControl:false,
			overviewMapControl:false,
			rotateControl:false
	  	}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var image = new google.maps.MarkerImage("images/home/pin.png", null, null, null, new google.maps.Size(40,52));
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(longitud, latitud),
            icon:image,
            map: map,
            title: empresa
        });
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', (function (marker) {
            return function () {
                infowindow.setContent(generateContent())
                infowindow.open(map, marker);
            }
        })(marker));
	}
	google.maps.event.addDomListener(window, 'load', initialize);
    function generateContent()
    {
        var content = `
            <div class="gd-bubble" style="">
                <div class="gd-bubble-inside">
                    <div class="geodir-bubble_desc">
                    <div class="geodir-bubble_image">
                        <div class="geodir-post-slider">
                            <div class="geodir-image-container geodir-image-sizes-medium_large ">
                                <div id="geodir_images_5de53f2a45254_189" class="geodir-image-wrapper" data-controlnav="1">
                                    <ul class="geodir-post-image geodir-images clearfix">
                                        <li>
                                            <div class="geodir-post-title">
                                                <h4 class="geodir-entry-title text-center">
                                                    `+empresa+`
                                                </h4>
                                            </div>
                                            <img src="`+logotipo+`" alt="`+empresa+`" class="align size-medium_large" width="25%" height="25%">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <br>
                <div class="geodir-bubble-meta-side">
                    <div class="geodir-output-location">
                    <div class="geodir-output-location geodir-output-location-mapbubble">
                        <div class="geodir_post_meta  geodir-field-post_title"><span class="geodir_post_meta_icon geodir-i-text">
                            <span class="geodir_post_meta_title">Dirección: </span></span>`+direccion[0].direction+`</span><br>
                            <span class="geodir_post_meta_title">Teléfono: </span></span>`+telefono[0].phone+`</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>`;
    return content;
    }
</script>
@endsection
