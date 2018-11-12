<!--<script type="text/javascript" src="/profile/files/js/mytables/orders/index.js"></script>-->

<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?
                    $active_econom = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 1])->all());
                    $active_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 2])->all());
                    $active_kk = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 3])->all());
                    $finished_econom = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 1])->all());
                    $finished_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 2])->all());
                    $finished_kk = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 3])->all());
                    $active_lady = count(\backend\models\Orders::find()->where(['in', 'status', [1, 2, 3, 4]])->andWhere(['order_type' => 4])->all());
                    $finished_lady = count(\backend\models\Orders::find()->where(['in', 'status', [5]])->andWhere(['order_type' => 4])->all());

                    $cancelled_econom = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 1])->all());
                    $cancelled_comfort = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 2])->all());
                    $cancelled_kk = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 3])->all());
                    $cancelled_lady = count(\backend\models\Orders::find()->where(['in', 'status', [0]])->andWhere(['order_type' => 4])->all());

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
                                <th>Межгород</th>
                                <th>Грузотакси</th>
                                <th>Инватакси</th>
                                <th>Эвакуатор</th>
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
                            <th><?=$mejgorod?></th>
                            <th><?=$gruz?></th>
                            <th><?=$inva?></th>
                            <th><?=$evak?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><a data-id=1 data-info="Эконом" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=2 data-info="Комфорт" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=3 data-info="Корпоративный клиент" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=4 data-info="Леди-такси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=1 data-info="Межгород" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=2 data-info="Грузотакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=4 data-info="Инватакси" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                            <th><a data-id=3 data-info="Эвакуатор" class="action-link" href="orders/orders-list"><button class="btn btn-success" type="button">Просмотр</button></a></th>
                         </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

