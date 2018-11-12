<?php
use backend\models\Users;
use backend\models\Facilities;
use backend\models\DriversFacilities;
use backend\models\DriversServices;
use backend\models\UsersPrivileges;
use backend\models\TaxiParkPrivileges;
use backend\models\TaxiPark;
use backend\models\CarModels;
use backend\models\Services;

?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<script src="bootstrap-switch.js"></script>
<link href="bootstrap.css" rel="stylesheet">
<link href="bootstrap-switch.css" rel="stylesheet">
<!---LOCAL --->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="/profile/files/js/mytables/drivers/form.js"></script>

<!------->

<?=$this->render("/layouts/header/_header", array("model" => $model))?>

<div class="content">
    <form id = "form">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-12">
                            <input name="id" type="hidden" class="form-control" value = "<?=$model->id?>">
                            <input name="_csrf-backend" type="hidden" class="form-control" value = "<?=Yii::$app->getRequest()->getCsrfToken()?>">
                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("ФИО", "name", "text", $model->name, "true")))?>
                    </div>



                    <? if($model == null){ ?>
                        <div class="col-md-6" style="margin-top: 2em;">
                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("Пароль", "password", "text", $model->password, "true")))?>
                        </div>
                    <? } ?>

                    <div class="col-md-6" style="margin-top: 2em;">
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Телефон", "phone", "text", $model->phone, "true")))?>
                    </div>

                    <div class="col-md-6" style="margin-top: 2em;">
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Год рождения", "year_of_birth", "number", $model->year_of_birth, "true", "1985")))?>
                    </div>

                    <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                        <?
                        if($model->car != null){
                            $my_car = $model->car;
                            $par_id = CarModels::find()->where(['id' => $my_car])->one();
                            $car_model = CarModels::find()->where(['id' => $par_id->parent_id])->one();


                            $submodels = CarModels::find()->where(['parent_id' => $par_id->parent_id])->all();

                        }
                        $models = CarModels::find()->where(['parent_id' => -1])->all();


                        ?>
                        <label class = "text-semibold">Марка автомобиля:</label>
                        <select onchange="models()" id="mark" name = "car" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($models as $key => $value) { ?>
                                <option <? if($car_model->id == $value->id){?>selected<?} ?> value="<?=$value->id?>"><?=$value->model?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                        <label class = "text-semibold">Модель автомобиля:</label>
                        <select id="model" name = "car_id" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($submodels as $key => $value) { ?>
                                <option <? if($model->car == $value->id){?>selected<?} ?> value="<?=$value->id?>"><?=$value->model?></option>
                            <? } ?>
                        </select>
                    </div>


                    <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Год выпуска машины", "car_year", "number", $model->car_year, "true", "2015")))?>
                    </div>


                    <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Гос. номер", "car_number", "text", $model->car_number, "true", "X 013 ZZZ")))?>
                    </div>

                    <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Баланс в монетах", "balance", "number", $model->balance, "false", "1000")))?>
                    </div>


                    <?
                    if($model->id != null){
                        $drivers_fac = DriversFacilities::find()->where(['driver_id' => $model->id])->all();
                        $servs = DriversServices::find()->where(['driver_id' => $model->id])->all();
                    }

                    $list = Facilities::find()->all();
                    $rand = rand();
                    ?>

                    <div class="col-md-12" style="padding-top: 1em; <? if($model->service_id == null){?> border-style: solid; border-color: coral; <?}?>">
                        <?
                        $services = Services::find()->all();
                        ?>
                        <label class = "text-semibold">Тип водителя:</label>
                        <select name = "ser[<?=$rand?>][]" class="select" id="ser" multiple required>
                            <?if($servs == null){
                                ?><option selected value="0">Не выбран</option><?
                            }?>
                            <? foreach ($services as $key => $value) { ?>
                                <option <? if($servs != null){ foreach ($servs as $v){ if($v->service_id == $value->id){ ?> selected <? } } }?> value="<?=$value->id?>"><?=$value->value?></option>
                            <? } ?>
                        </select>
                    </div>


                    <div class="col-md-12" style="margin-top: 2em;">

                        <label class = "text-semibold">Доп условия:</label>
                        <select name = "fac[<?=$rand?>][]" class="select" id="fac" multiple style="border-color: #ff6666; border-width: 24px">
                            <?if($drivers_fac == null){
                                ?><option selected value="0">Не выбран</option><?
                            }?>

                            <? foreach ($list as $key => $value) { ?>
                                <option <? if($drivers_fac != null){ foreach ($drivers_fac as $v){ if($v->facility_id == $value->id){ ?> selected <? } } }?> value="<?=$value->id?>"><?=$value->name?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="col-md-12" style="margin-top: 2em;">
                        <?
                        $parks = Taxipark::find()->all();
                        ?>
                        <input hidden name="services" id="serv">

                        <input hidden name="facilities" id="facil">
                        <label class = "text-semibold">Таксопарк:</label>
                        <select name = "taxi_park_id" class="select">
                            <option value="0">Не выбран (Taxi+)</option>
                            <? foreach ($parks as $key => $value) { ?>
                                <option <? if($model->taxi_park_id == $value->id){?>selected<?} ?> value="<?=$value->id?>"><?=$value->name?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-top: 2em;">
                        <?
                        $checked = false;
                        $show = false;
                        $user = UsersPrivileges::find()->where(['user_id' => $model->id])->one();
                        if($user != null){
                            $checked = true;
                            $show = true;
                            ?>
                            <?
                        }else{
                            $me = Users::find()->where(['id' => Yii::$app->session->get("profile_id")])->one();
                            $tp = TaxiParkPrivileges::find()->where(['taxi_park_id' => $me->taxi_park_id])->andWhere(['service_id' => $model->service_id])->one();
                            if($tp != null){
                                if($tp->amount > 0){
                                    $show = true;
                                }
                            }
                        }
                        if($show){
                            ?>
                            <label class = "text-semibold">Доступ к общему чату:</label>
                            <?
                         if($checked){
                            ?>
                             <input type="checkbox" name="access" checked data-on-color="success" data-off-color="danger" data-on-text="Доступен" data-off-text="Заблокирован" class="switch">
                             <?
                         }   else{
                             ?>
                             <input type="checkbox" name="access" data-on-color="success" data-off-color="danger" data-on-text="Доступен" data-off-text="Заблокирован" class="switch">
                             <?
                         }


                        }
                        ?>
                    </div>

                    <div class = "col-md-12" style="margin-top: 2em;">
                        <div class="text-right">


                            <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>
                            <? if ($model->id != null) { ?>
                                <a href = "#delete" data-id = "<?=$model->id?>" data-table = "users" data-redirect = "admins" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>
                            <? } ?>
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-check position-right"></i></button>
                        </div>
                    </div>


                </div>
            </div>
    </form>
</div>



<script>
    $(document).ready(function() {
        $("[name='access']").bootstrapSwitch();

        $(document.body).on("change","#fac",function(){

            var countries = [];
            $.each($("#fac option:selected"), function(){
                countries.push($(this).val());
            });
            $('#facil').val(countries);
            var val = $('#facil').val();
            //console.log('value ' + val);

        });

        $(document.body).on("change","#ser",function(){

            var countries1 = [];
            $.each($("#ser option:selected"), function(){
                countries1.push($(this).val());
            });
            $('#serv').val(countries1);
            var val = $('#serv').val();
            console.log('value ' + val);

        });



        });

    function models() {
        var id = document.getElementById('mark').value;
        console.log(id);
        $.ajax({url: "moderators/get-models/",
            type: 'POST',
            data: {id:id},
            success: function(result) {
                var array = result.models;
                var selectList = document.getElementById('model');
                selectList.innerHTML = '';

                for (var i = 0; i < array.length; i++) {
                    var option = document.createElement("option");
                    option.value = array[i].id;
                    option.text = array[i].model;
                    selectList.appendChild(option);
                }

                $('#model').select2();
            }


        });
    }


//        $("button").click(function(){
//
//        });
</script>