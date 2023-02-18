@extends('layouts.main')


@section('header-scripts')

<style>
    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;

    }

    #map { height: 180px; }
</style>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>


@endsection

@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="{{url()->previous()}}" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Absensi</div>
    <div class="right">
        <a href="{{url('/')}}" class="headerButton goBack">
            <ion-icon name="home-outline"></ion-icon>
        </a>
    </div>
</div>
@endsection


@section('content')

<div class="row" style="margin-top: 70px;">
    <div class="col">
        {{-- <input type="text" id="my_location" required> --}}
        <div class="webcam-capture"></div>
    </div>
</div>

<div class="row">
    <div class="col">
        @if (isset($cek_absen))

        @if ($cek_absen->jam_pulang === null)
        <button id="takeAbsen" class="btn btn-warning btn-block">
            <ion-icon name="camera-outline"></ion-icon>
                Absen Pulang</button>
        @else
        <button id="takeAbsen"  class="btn btn-success btn-block">
                Telah Absen</button>
            
        @endif
     
        @else
        <button id="takeAbsen" class="btn btn-primary btn-block">
            <ion-icon name="camera-outline"></ion-icon>
                Absen Masuk</button>
        @endif

    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
@endsection

@section('footer-scripts')
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

<script>
    Webcam.set({
        height:480,
        width:640,
        image_format:'jpeg',
        jpeg_quality:80
    });

    Webcam.attach('.webcam-capture');


    var lokasi_kantor = {!! json_encode($lokasi_kantor) !!}

    var my_location = 0;
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position){
        my_location = position.coords.latitude + "," + position.coords.longitude;

        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 100);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([lokasi_kantor['latitude'], lokasi_kantor['longitude']], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 20
        }).addTo(map);

        
    }

    function errorCallback(){


    }


    $("#takeAbsen").click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        });

        $.ajax({
            type: 'POST',
            url: '/absensi/post/store',
            data:{
                _token: "{{ csrf_token() }}",
                image: image,
                lokasi : my_location
            },
            cache:false,
            success: function(respond){
                var status = respond.split("|");
                if (status[0] == 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: status[1],
                        icon: 'success'
                    });
                    setTimeout("location.href='/'", 3000)
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: status[1],
                        icon: 'error'
                    });
                }
            }
        })
    });


</script>
@endsection