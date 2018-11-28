<!--<script type="text/javascript" src="/profile/files/js/mytables/orders/index.js"></script>-->

<?//=$this->render("/layouts/header/_header")?>
<script type="text/javascript" src="/profile/files/js/mytables/filtr.js"></script>

<div class="navbar navbar-default navbar-xs navbar-component" style = "margin-bottom:0;">
    <div class="navbar-collapse collapse" id="navbar-filter">
        <p class="navbar-text">Фильтр:</p>
        <li class="dropdown">
            <a href="#"  class="daterange-picker filtr-toggle dropdown-toggle"><i class="icon-calendar" position-left"></i> Сортировать по дате <span class="caret"></span></a>
        </li>
    </div>
</div>

<?
use backend\components\Helpers;
?>
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?
                    $cond= '';
                    if(Yii::$app->session->get('profile_role') == 9){
                        $cond = 'orders.id IS NOT null';
                    }elseif (Yii::$app->session->get('profile_role') == 3){
                        $me = \backend\models\SystemUsers::findOne(['id' => Yii::$app->session->get('profile_id')]);
                        $my_cities = \backend\models\SystemUsersCities::find()->where(['system_user_id' => $me->id])->all();
                        $in = '';
                        foreach ($my_cities as $k => $v){
                            if($k == count($my_cities) - 1){
                                $in .= $v->city_id;
                            }else{
                                $in .= $v->city_id . ', ';
                            }
                            $cond = 'cities.id in (' . $in . ')';
                        }
                    }elseif (Helpers::getMyRole() == 5){
                        $cond = 'orders.taxi_park_id = ' . Helpers::getMyTaxipark();
                    }

                    $active_econom = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 1])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $active_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 2])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $active_kk = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 3])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $finished_econom = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 1])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $finished_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 2])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $finished_kk = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 3])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $active_lady = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 4])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $finished_lady = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 4])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());

                    $cancelled_econom = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 1])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $cancelled_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 2])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $cancelled_kk = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 3])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());
                    $cancelled_lady = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 4])->innerJoin('users', 'users.id = orders.user_id')->innerJoin('cities', 'cities.id = users.city_id')->andWhere($cond)->andWhere('orders.taxi_park_id = '. Helpers::getMyTaxipark())->all());

                    $mejgorod = count(\backend\models\SpecificOrders::findAll(['order_type_id' => 1]));
                    $gruz = count(\backend\models\SpecificOrders::findAll(['order_type_id' => 2]));
                    $evak = count(\backend\models\SpecificOrders::findAll(['order_type_id' => 3]));
                    $inva = count(\backend\models\SpecificOrders::findAll(['order_type_id' => 4]));
                    ?>
<!--                    --><?//=$this->render('/layouts/header/_filter', array('page' => $page))?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>П/П</th>
                                <th>Эконом</th>
                                <th>Комфорт</th>
                                <th>КК</th>
                                <th>Леди такси</th>
                                <?
                                if(Helpers::getMyRole() != 5){
                                    ?>

                                    <th>Межгород</th>
                                    <th>Грузотакси</th>
                                    <th>Инватакси</th>
                                    <th>Эвакуатор</th>

                                    <?
                                }
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Активные</th>
                            <th><?=$active_econom?></th>
                            <th><?=$active_comfort?></th>
                            <th><?=$active_kk?></th>
                            <th><?=$active_lady?></th>
                        </tr>
                        <tr>
                            <th>Завершенные</th>
                            <th><?=$finished_econom?></th>
                            <th><?=$finished_comfort?></th>
                            <th><?=$finished_kk?></th>
                            <th><?=$finished_lady?></th>

                        </tr>
                        <tr>
                            <th>Отмененные</th>
                            <th><?=$cancelled_econom?></th>
                            <th><?=$cancelled_comfort?></th>
                            <th><?=$cancelled_kk?></th>
                            <th><?=$cancelled_lady?></th>

                        </tr>
                        <tr>
                            <th>Итого</th>
                            <th><?=$cancelled_econom + $active_econom + $finished_econom?></th>
                            <th><?=$cancelled_comfort + $active_comfort + $finished_comfort?></th>
                            <th><?=$cancelled_kk + $active_kk + $finished_kk?></th>
                            <th><?=$cancelled_lady + $active_lady + $finished_lady?></th>
                            <?
                            if(Helpers::getMyRole() != 5){
                                ?>
                                <th><?=$mejgorod?></th>
                                <th><?=$gruz?></th>
                                <th><?=$inva?></th>
                                <th><?=$evak?></th>
                                <?
                            }
                            ?>

                        </tr>
                        <tr>
                            <th></th>
                            <th><a data-id=1 data-info="Эконом" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=2 data-info="Комфорт" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=3 data-info="Корпоративный клиент" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=4 data-info="Леди-такси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <?
                            if(Helpers::getMyRole() != 5){
                                ?>
                                <th><a data-id=1 data-info="Межгород" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                                <th><a data-id=2 data-info="Грузотакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                                <th><a data-id=4 data-info="Инватакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                                <th><a data-id=3 data-info="Эвакуатор" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>

                                <?
                            }
                            ?>
                                                    </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var token = $('meta[name=csrf-token]').attr("content");
        $('.daterange-picker').daterangepicker(
            {
                startDate: <? if ($array_filtr[$page][$global_key]['start'] != null) { echo '"'.date("d/m/y", $array_filtr[$page][$global_key]['start']).'"'; } else { ?>moment().subtract(29, 'days')<? } ?>,
                endDate: <? if ($array_filtr[$page][$global_key]['end'] != null) { echo '"'.date("d/m/y", $array_filtr[$page][$global_key]['end']).'"'; } else { ?>moment()<? } ?>,
                dateLimit: { days: 120 },
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошедший месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Вперед',
                    cancelLabel: 'Отмена',
                    startLabel: 'Начальная дата',
                    endLabel: 'Конечная дата',
                    customRangeLabel: 'Выбрать дату',
                    daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    firstDay: 1
                },
                opens: 'right',
                applyClass: 'btn-small bg-primary',
                cancelClass: 'btn-small btn-default'
            },
            function(start, end) {
                $.ajax({
                    type: "POST",
                    url: "/profile/tables/filtrdate/",
                    data:{"_csrf-backend":token, page:"<?=$page?>", field:"<?=$global_key?>", start:start.format('DD.MM.YYYY HH:MM'), end:end.format('DD.MM.YYYY HH:MM')},
                    success: function() {
                        $('#<?=$page?>').trigger('click');
                    },
                }).fail(function (xhr) {
                    console.log(xhr. responseText);
                });
            },
        );

    });
</script>