<?php
use backend\models\Orders;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>

<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/add_order/form.js"></script>
<!------->
<?=$this->render("/layouts/header/_header", array("model" => $model))?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<div class="content">
    <form id = "form">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="map" style="padding-left: 1em; padding-right: 1em; padding-bottom: 1em; padding-top: 1em; height: 600px "></div>

                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" >
var token = '<?=Yii::$app->session->get('token')?>';
var laa = null;
var lab = null;
var loa = null;
var lob = null;

    setTimeout(function(){
        ymaps.ready(init);

        function init() {
            // Стоимость за километр.

            var geolocation = ymaps.geolocation,
                myMap = new ymaps.Map('map', {
                    center: [55, 34],
                    zoom: 10,
                    controls: []
                });

            geolocation.get({
                provider: 'yandex',
                mapStateAutoApply: true
            }).then(function (result) {
                result.geoObjects.options.set('preset', 'islands#redCircleIcon');
                result.geoObjects.get(0).properties.set({
                    balloonContentBody: 'Мое местоположение'
                });
                myMap.geoObjects.add(result.geoObjects);
            });


            var DELIVERY_TARIFF = 20,
                // Минимальная стоимость.
                MINIMUM_COST = 500;
                // myMap = new ymaps.Map('map', {
                //     center: [60.906882, 30.067233],
                //     zoom: 9,
                //     controls: []
                // }),
                // Создадим панель маршрутизации.
                routePanelControl = new ymaps.control.RoutePanel({
                    options: {
                        // Добавим заголовок панели.
                        showHeader: true,
                        title: 'Расчёт доставки'
                    }
                }),
                zoomControl = new ymaps.control.ZoomControl({
                    options: {
                        size: 'small',
                        float: 'none',
                        position: {
                            bottom: 145,
                            right: 10
                        }
                    }
                });




            // Пользователь сможет построить только автомобильный маршрут.
            routePanelControl.routePanel.options.set({
                types: {auto: true}
            });



            myMap.controls.add(routePanelControl).add(zoomControl);

            // Получим ссылку на маршрут.
            routePanelControl.routePanel.getRouteAsync().then(function (route) {

                // Зададим максимально допустимое число маршрутов, возвращаемых мультимаршрутизатором.
                route.model.setParams({results: 1}, true);

                // Повесим обработчик на событие построения маршрута.
                route.model.events.add('requestsuccess', function () {
                    console.log('aa');
                    var activeRoute = route.getActiveRoute();

                    if (activeRoute) {
                        laa = route.model.properties._data.waypoints[0].coordinates[0];
                        lab = route.model.properties._data.waypoints[1].coordinates[0];
                        loa = route.model.properties._data.waypoints[0].coordinates[1];
                        lob = route.model.properties._data.waypoints[1].coordinates[1];
                        // var token = //Yii::$app->session->get('token');
                        var result = null;
                        $.ajax({
                            dataType: "json",
                            async: false,
                            type: "POST",
                            global: false,
                            url: "/profile/account/get-price/",
                            data: {token: token, longitude_a: route.model.properties._data.waypoints[0].coordinates[1], latitude_a: route.model.properties._data.waypoints[0].coordinates[0],
                                longitude_b: route.model.properties._data.waypoints[1].coordinates[1], latitude_b: route.model.properties._data.waypoints[1].coordinates[0], type: 1},
                            success: function (data) {
                                console.log(data);
                                var price = data.price_list[0].price;
                                var length = route.getActiveRoute().properties.get("distance");
                                balloonContentLayout = ymaps.templateLayoutFactory.createClass(
                                    '<span>Расстояние: ' + length.text + '.</span><br/>' +
                                    '<span style="font-weight: bold; font-style: italic"> Cost: ' + price + ' tg. </span>' + '<br>' +
                                    '<button type="button" onclick="makeOrder(laa, loa, lab, lob, token)" class="btn btn-primary"> Oформить заказ </button>');
                                // Зададим этот макет для содержимого балуна.
                                route.options.set('routeBalloonContentLayout', balloonContentLayout);
                                // Откроем балун.
                                activeRoute.balloon.open();
//
                            }
                        });

                        // Получим протяженность маршрута.
                        var length = route.getActiveRoute().properties.get("distance");
                            // Вычислим стоимость доставки.
                            // price = calculate(Math.round(length.value / 1000)),
                            // Создадим макет содержимого балуна маршрута.

                    }
                });

            });
            // Функция, вычисляющая стоимость доставки.
            function calculate(routeLength) {
                return Math.max(routeLength * DELIVERY_TARIFF, MINIMUM_COST);
            }


        }




    }, 3000);

function makeOrder(laa, loa, lab, lob, tok) {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "/profile/account/make-order/",
        data: {token: tok, longitude_a: loa, latitude_a: laa,
            longitude_b: lob, latitude_b: lab, service_id: 1},
        success: function (data) {
            console.log(data);
            if(data.state == 'success'){
                swal({
                    title: 'Success!',
                    timer: 900,
                    type: 'success',
                    showConfirmButton: false
                });
                $('#').trigger('click');

            }

        },
        default: function (data) {
            console.log(data);
        }
    });
}
</script>