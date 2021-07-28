<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-main')</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--    <script src="{{ asset('./js/app.js') }}" defer></script>--}}
</head>
<body class="font-sans antialiased">

<div style="margin: 30px 0;text-align: center;">
    <h1>Main page</h1>
<input id="city-input" placeholder="Enter City" value=""/>
<button class="click-country btn btn-primary">Country</button>
</div>

<table border='1' cellpadding='15' cellspacing='0'>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Time</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Temp</th>
        <th>Pressure</th>
        <th>Humidity</th>
        <th>Temp_min</th>
        <th>Temp_max</th>
    </tr>
    </thead>
    <tbody id="res">

    </tbody>
</table>


<section class="country">

</section>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
        integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
        crossorigin="anonymous"></script>

<script>
    jQuery(document).ready(function ($) {
        let cityButton = document.querySelector('.click-country');

        cityButton.addEventListener('click', function () {
            let city = document.querySelector('#city-input').value;
            setInterval(function () {

                fetch('https://api.openweathermap.org/data/2.5/weather?q=' + city + '&appid=bf65d8b174418831a16055a19f50144f')
                    .then(function (resp) {
                        return resp.json()
                    }) // Convert data to json
                    .then(function (data) {
                        country(data)
                    })
                    .catch(function () {
                        // catch any errors
                    });

                function country(myData) {

                    let formData = new FormData();
                    formData.append('name', myData.name);
                    formData.append('time', myData.dt);
                    formData.append('latitude', myData.coord.lat);
                    formData.append('longitude', myData.coord.lon);
                    formData.append('temp', myData.main.temp);
                    formData.append('pressure', myData.main.pressure);
                    formData.append('humidity', myData.main.humidity);
                    formData.append('temp_min', myData.main.temp_min);
                    formData.append('temp_max', myData.main.temp_max);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/region/submit',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            getRegion(data)
                            console.log(data)
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    })
                }
            }, 120000)
        })

        function getRegion(item) {

            let tab = "";

            tab = `<tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.time}</td>
            <td>${item.latitude}</td>
            <td>${item.longitude}</td>
            <td>${item.temp}</td>
            <td>${item.pressure}</td>
            <td>${item.humidity}</td>
            <td>${item.temp_min}</td>
            <td>${item.temp_max}</td>
            </tr>`

            $("#res").append(tab);
        }

    })
</script>
</body>
</html>
