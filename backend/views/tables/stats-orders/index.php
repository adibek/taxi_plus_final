<!--<script type="text/javascript" src="/profile/files/js/mytables/orders/index.js"></script>-->
<?php
use backend\models\Orders;
use backend\models\SpecificOrders;
?>
<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body" >
<?
$ekonom1 = Orders::find()->where(['order_type' => 1])->andWhere(['status' => 5])->count();
$ekonom2 = Orders::find()->where(['order_type' => 1])  ->andWhere(['or', ['status'=>0], ['deleted'=>1]])->count();

$komfort1 = Orders::find()->where(['order_type' => 2])->andWhere(['status' => 5])->count();
$komfort2 = Orders::find()->where(['order_type' => 2])  ->andWhere(['or', ['status'=>0], ['deleted'=>1]])->count();

$kk1 = Orders::find()->where(['order_type' => 3])->andWhere(['status' => 5])->count();
$kk2 = Orders::find()->where(['order_type' => 3])  ->andWhere(['or', ['status'=>0], ['deleted'=>1]])->count();

$lady1 = Orders::find()->where(['order_type' => 4])->andWhere(['status' => 5])->count();
$lady2 = Orders::find()->where(['order_type' => 4])  ->andWhere(['or', ['status'=>0], ['deleted'=>1]])->count();

$mejgorod = SpecificOrders::find()->where(['order_type_id' => 1])->count();
$gruz = SpecificOrders::find()->where(['order_type_id' => 2])->count();
$evak = SpecificOrders::find()->where(['order_type_id' => 3])->count();
$inva = SpecificOrders::find()->where(['order_type_id' => 4])->count();
?>
                    <TABLE class="table table-bordered" style="padding-right: 1em; padding-left: 1em;">
                        <TR>
                            <td></td>
                            <TH colspan="2">Эконом</TH>
                            <TH colspan="2">Комфорт</TH>
                            <TH colspan="2">Корп. клиенты</TH>
                            <TH colspan="2">Леди такси</TH>
                            <TH colspan="1">Межгород</TH>
                            <TH colspan="1">Грузотакси</TH>
                            <TH colspan="1">Инватакси</TH>
                            <TH colspan="1">Эвакуатор</TH>
                        </TR>
                        <TR>
                            <td></td>
                            <TH>Отработанные</TH>
                            <TH>Не отработанные</TH>
                            <TH>Отработанные</TH>
                            <TH>Не отработанные</TH>
                            <TH>Отработанные</TH>
                            <TH>Не отработанные</TH>
                            <TH>Отработанные</TH>
                            <TH>Не отработанные</TH>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </TR>
                        <TR>
                            <td></td>
                            <TD><?=$ekonom1 ?></TD>
                            <TD><?=$ekonom2?></TD>
                            <TD><?=$komfort1?></TD>
                            <TD><?=$komfort2?></TD>
                            <TD><?=$kk1?></TD>
                            <TD><?=$kk2?></TD>
                            <TD><?=$lady1?></TD>
                            <TD><?=$lady2?></TD>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </TR>
                        <TR>
                            <td>Итого</td>
                            <TH colspan="2"><?=$ekonom2 + $ekonom1?></TH>
                            <TH colspan="2"><?=$komfort2 + $komfort1?></TH>
                            <TH colspan="2"><?= $kk2 + $kk1?></TH>
                            <TH colspan="2"><?= $lady2 + $lady1?></TH>
                            <TH colspan="1"><?=$mejgorod?></TH>
                            <TH colspan="1"><?=$gruz?></TH>
                            <TH colspan="1"><?=$inva?></TH>
                            <TH colspan="1"><?=$evak?></TH>
                        </TR>


                    </TABLE>
                    <!--                    --><?//=$this->render('/layouts/header/_filter', array('page' => $page))?>
<!--                    <table class="table">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th>П/П</th>-->
<!--                            <th>Эконом</th>-->
<!--                            <th>Комфорт</th>-->
<!--                            <th>КК</th>-->
<!--                            <th>Леди такси</th>-->
<!--                            <th>Межгород</th>-->
<!--                            <th>Грузотакси</th>-->
<!--                            <th>Инватакси</th>-->
<!--                            <th>Эвакуатор</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        <tr>-->
<!--                            <th>Активные</th>-->
<!--                            <th>--><?//=$active_econom?><!--</th>-->
<!--                            <th>--><?//=$active_comfort?><!--</th>-->
<!--                            <th>--><?//=$active_kk?><!--</th>-->
<!--                            <th>--><?//=$active_lady?><!--</th>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Завершенные</th>-->
<!--                            <th>--><?//=$finished_econom?><!--</th>-->
<!--                            <th>--><?//=$finished_comfort?><!--</th>-->
<!--                            <th>--><?//=$finished_kk?><!--</th>-->
<!--                            <th>--><?//=$finished_lady?><!--</th>-->
<!---->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Отмененные</th>-->
<!--                            <th>--><?//=$cancelled_econom?><!--</th>-->
<!--                            <th>--><?//=$cancelled_comfort?><!--</th>-->
<!--                            <th>--><?//=$cancelled_kk?><!--</th>-->
<!--                            <th>--><?//=$cancelled_lady?><!--</th>-->
<!---->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Итого</th>-->
<!--                            <th>--><?//=$cancelled_econom + $active_econom + $finished_econom?><!--</th>-->
<!--                            <th>--><?//=$cancelled_comfort + $active_comfort + $finished_comfort?><!--</th>-->
<!--                            <th>--><?//=$cancelled_kk + $active_kk + $finished_kk?><!--</th>-->
<!--                            <th>--><?//=$cancelled_lady + $active_lady + $finished_lady?><!--</th>-->
<!--                            <th>--><?//=$mejgorod?><!--</th>-->
<!--                            <th>--><?//=$gruz?><!--</th>-->
<!--                            <th>--><?//=$inva?><!--</th>-->
<!--                            <th>--><?//=$evak?><!--</th>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th></th>-->
<!--                            <th><a data-id=1 data-info="Эконом" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=2 data-info="Комфорт" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=3 data-info="Корпоративный клиент" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=4 data-info="Леди-такси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=1 data-info="Межгород" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=2 data-info="Грузотакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=4 data-info="Инватакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                            <th><a data-id=3 data-info="Эвакуатор" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>-->
<!--                        </tr>-->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

