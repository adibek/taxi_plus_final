<?php
use backend\models\WorkingTypes;
use backend\models\Cities;
use backend\models\TaxiParkServices;
use backend\models\Services;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>

<script type="text/javascript" src="/profile/files/js/mytables/taxi-parks/form.js"></script>
<!------->
<style>
    /* Set the size of the div element that contains the map */
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
</style>
<?=$this->render("/layouts/header/_header", array("model" => $model))?>

<div class="content">
    <form id = "form">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-md-12">



                    <input id="inp" onchange="setRadius()"> <a onclick="setRadius()"> SET RADIUS</a>
                        <div style="margin-top: 3em; margin-bottom: 3em;" id="map" ></div>



                        <div class="text-right">
                            <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>
                            <? if ($model->id != null) { ?>
                                <a href = "#delete" data-id = "<?=$model->id?>" data-table = "taxi_park" data-redirect = "taxi-parks" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>
                            <? } ?>
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-check position-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    function setRadius() {
        var val = document.querySelector('#inp').value;
        cityCircle.setRadius(parseInt(val));
    }
    var map, infoWindow;
    var cityCircle;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 10
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';

                var marker = new google.maps.Marker({
                    icon: image,
                    position: pos,
                    map: map,
                    draggable: true,
                    title: 'Hello World!'
                });
                cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: marker.position,
                    radius: 2000
                });

                google.maps.event.addListener(marker, 'dragend', function()
                {
                    geocodePosition(marker.getPosition());
                    cityCircle.setCenter(marker.position);
                    cityCircle.map = map;
                });

                function geocodePosition(pos)
                {
                    geocoder = new google.maps.Geocoder();
                    geocoder.geocode
                    ({
                            latLng: pos
                        },
                        function(results, status)
                        {
                            if (status == google.maps.GeocoderStatus.OK)
                            {

//                                alert(results[0].formatted_address);

                            }
                            else
                            {

                            }
                        }
                    );
                }



                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>


<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQacFtBBzmXw9NHkRht8-LH9rJxJ482kk&callback=initMap">
</script>
