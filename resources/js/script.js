jQuery(document).ready(function ($) {
    let clickCountry = document.querySelector('.click-country');

    clickCountry.addEventListener('click', function () {
        // setInterval(function(){
        fetch('https://api.openweathermap.org/data/2.5/weather?q=Erevan&appid=bf65d8b174418831a16055a19f50144f')
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
            // console.log(myData)
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
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }
    })

    function getRegion(region) {

        let tab = "";
        region.forEach((item, index) => {
            tab = `<tr>
            <td>${index + 1}</td>
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
        });
    }

})
