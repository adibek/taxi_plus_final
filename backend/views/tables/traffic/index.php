<!--<script type="text/javascript" src="/profile/files/js/mytables/traffic/index.js"></script>-->

<?=$this->render("/layouts/header/_header")?>
<?
$tp1 = \backend\models\MonetsTraffic::find()->where(['type_id' => 1])->andWhere(['reciever_user_id' => 111])->andWhere(['sender_tp_id' => 0])->sum('amount');
$driver = \backend\models\MonetsTraffic::find()->where(['type_id' => 1])->andWhere(['<>', 'reciever_user_id', 111])->andWhere(['sender_tp_id' => 0])->sum('amount');
$companies = \backend\models\Company::find()->sum('balance');
$drivers = \backend\models\Users::find()->where(['role_id' => 2])->sum('balance');
$users = \backend\models\Users::find()->where(['role_id' => 1])->sum('balance');
$tps = \backend\models\TaxiPark::find()->where(['<>', 'id', 0])->sum('balance');
?>
<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?=$this->render('/layouts/header/_filter', array('page' => $page))?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th colspan="3">Выданные монеты</th>
                            <th colspan="4">Возвратные монеты</th>
                            <th>Сальдо</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Таксопаркам</td>
                            <td>Водителям Taxi+</td>
                            <td>Компаниям</td>
                            <td>Монеты компаний</td>
                            <td>Монеты водителей</td>
                            <td>Монеты клиентов</td>
                            <td>Монеты таксопарков</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Итого</td>
                            <td><?=$tp1?></td>
                            <td><?=$driver?></td>
                            <td>0</td>
                            <td><?=$companies?></td>
                            <td><?=$drivers?></td>
                            <td><?=$users?></td>
                            <td><?=$tps?></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

