<?php
use backend\models\Privileges;
use backend\models\UsersPrivileges;
use backend\models\TaxiParkPrivileges;
use backend\models\Cities;
use backend\models\TaxiParkServices;
use backend\models\Services;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<!--<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>-->

<!---LOCAL --->
<!--<script type="text/javascript" src="/profile/files/js/mytables/settings/form.js"></script>-->
<!------->

<?=$this->render("/layouts/header/_header", array("model" => $model))?>

<div class="content">
    <form id = "form">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-md-12">

                    <?

                        $services = Services::find()->all();
                        $my_services = TaxiParkPrivileges::find()->where(['taxi_park_id' => Yii::$app->session->get("profile_tp")])->all();

                        foreach ($services as $k => $v){
                            ?>
                            <h5>Класс: <?=$v->value ?>. Цена на доступ одного водителя к общему чату: <?=$v->access_price?> </h5><br>
                            <?
                            $ser = TaxiParkPrivileges::find()->where(['taxi_park_id' => Yii::$app->session->get("profile_tp")])->andWhere(['service_id' => $v->id])->one();
                            $count = 0;
                            if($ser != null){
                                $count = $ser->amount;
                            }
                            ?>

                            <label class="text-semibold">Вашему таксопарку на данный момент доступно <?=$count?> штук</label><br>
                            <label class="text-semibold">Введите количество водителей, кому хотите приобрести доступ к общему чату "<?=$v->value?>"</label>
                            <input required id="num<?=$v->id?>" name="number" placeholder="5"  class="form-control" type="number">
                            <br><br>
                            <?


                    }

                    ?>


<!--                    <label class="text-semibold">Вашему таксопарку на данный момент доступно --><?//=$count->amount?><!-- штук</label>-->
<!--                    <br>-->
<!---->
<!--                    <label class="text-semibold">Для скольких водителей желаете приобрести доступ к заявкам общего чата?</label>-->
<!--                    <input required id="num" name="number" placeholder="5"  class="form-control" type="number">-->


                    <div class="text-right" style="margin-top: 2em;">

                        <button onclick="pay()" class="btn-primary" >Оплатить</button>
                    </div>

                </div>
            </div>
    </form>
</div>
<script type="text/javascript">

    function pay() {

        var count = <?=count($services)?>;
        var arr = [];
        for(var i = 1; i<count; i++){
            if($("#num" + i).val() != ''){}{
                arr[i] = $("#num" + i).val();
//                arr.push();
            }
        }

        $.ajax({url: "site/buy-access/",
            method: 'POST',
            data: {amount:arr},
            success: function(result){
            if(result.type == 'error'){
                swal({
                    title: 'Внимание, у Вашего таксопарка недостаточно монет',
                    type: 'error',
                    showConfirmButton: true
                });
            }else{
                swal({
                    title: 'Вы успещно приобрели услугу',
                    type: 'success',
                    showConfirmButton: true
                });
            }

            }

        });
    }

</script>