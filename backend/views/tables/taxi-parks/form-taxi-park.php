<?php
use backend\models\WorkingTypes;
use backend\models\Cities;
use backend\models\TaxiParkServices;
use backend\models\Services;
use backend\models\RadialPricing;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/taxi-parks/form.js"></script>
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

                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Название", "name", "text", $model->name, "true")))?>
<!--                        --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Компания", "company_name", "text", $model->company_name, "true")))?>
                        <label class="text-semibold">Название компании:</label>
                        <input value="<?=$model->company_name?>" type="text" name="company_name" class="form-control">


                        <?
                        $list = WorkingTypes::find()->all();
                        $cities = Cities::find()->all();
                        if(\backend\components\Helpers::getMyRole() == 3){
                            $cities = Cities::find()->where('id in ('.\backend\components\Helpers::getCitiesString().')')->all();
                        }
                        ?>


                        <label class = "text-semibold">Город:</label>
                        <select name = "city_id" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($cities as $key => $value) { ?>
                                <option <? if ($value->id == $model->city_id) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->cname?></option>
                            <? } ?>
                        </select>

                        <label style="margin-top: 1em;" class = "text-semibold">Тип оплаты:</label>
                        <select id="type" <? if(Yii::$app->session->get("profile_role") != 9){?> disabled <?} ?> name = "payment" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($list as $key => $value) { ?>
                                <option <? if ($value->id == $model->type) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->description?></option>
                            <? } ?>
                        </select>
                        <div id="add">
                            <?
                            if($model->type == 12 OR $model->type == 16){
                                ?>
                                <label class="text-semibold"></label>
                                <label class="text-semibold">Сумма:</label>
<!--                                --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Настройка для статистики фиксированной арендной платой ", "sum", "number", $model->sum, "true")))?>
                                <input type="number" name="sum" value="<?=$model->sum?>" class="form-control">
                                <?
                            }elseif ($model->type == 13 OR $model->type == 17){
                                ?>
<!--                                --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Доля таксопарка в процентах:", "dole_tp", "number", $model->dole_tp, "true")))?>
<!--                                --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Доля водителя в процентах:", "dole_driver", "number", $model->dole_driver, "true")))?>
                                <label class="text-semibold">Доля таксопарка в процентах:</label>
                                <input value="<?=$model->percent?>" type="number" name="dole_tp" class="form-control">
                                <label class="text-semibold">Доля водителя в процентах:</label>
                                <input value="<?=100 - $model->percent?>" type="number" name="dole_driver" class="form-control">
                                <?
                            }elseif ($model->type == 15 or $model->type == 18){
                                ?>
<!--                                --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Километры:", "km", "number", $model->km, "true")))?>
<!--                                --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Тенге:", "tg", "number", $model->tg, "true")))?>

                                <label class="text-semibold">Километры:</label>
                                <input value="<?=$model->km?>" type="number" name="km" class="form-control">

                                <label class="text-semibold">Тенге:</label>
                                <input value="<?=$model->tg?>" type="number" name="tg" class="form-control">
                                <?
                            }
                            ?>
                        </div>
                    </div>



                    <div class = "col-md-12 mt-15">

                        <div class="text-left" style="padding-top: 2em">
<!--                            <button class="btn btn-default" type="button" onclick="add()"> Добавить услугу</button>-->
                        </div>
                        <div class="text-right">
                            <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>
                            <? if ($model->id != null) { ?>
                                <a href = "#delete" data-id = "<?=$model->id?>" data-table = "taxi_park" data-redirect = "taxi-parks" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>
                            <? } ?>
                            <button  type="submit" class="btn btn-primary">Сохранить <i class="icon-check position-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

<script>


    $(document).ready(function() {
        $( "#type" ).change(function() {
            var id = document.getElementById('type').value;
            document.getElementById('add').innerText = '';
            switch(id) {
                case '12':
                    fix();
                    break;
                case '13':
                    dol();
                    break;
                case '14':
                    km();
                    break;
                case '16':
                    fix();
                    break;
                case '17':
                    dol();
                case '18':
                    km();
                default:
                    break;
            }
        });
        function fix() {
            var div = document.getElementById('add');
            var input = document.createElement('input');
            input.type = 'number';
            input.name = 'fix';
            input.classList.toggle('form-control');
            var label = document.createElement('label');
            label.classList.toggle('text-semibold');
            label.innerText = "Настройка для статистики фиксированной арендной платой \nСумма:";
            label.setAttribute('style', 'margin-top: 1em;');
            div.appendChild(label);
            div.appendChild(input);
        }
        function dol() {
            var div = document.getElementById('add');
            var input = document.createElement('input');
            input.type = 'number';
            input.name = 'dole_tp';
            input.classList.toggle('form-control');
            var label = document.createElement('label');
            label.classList.toggle('text-semibold');
            label.innerText = "Доля таксопарка в процентах:";
            label.setAttribute('style', 'margin-top: 1em;');

            var input1 = document.createElement('input');
            input1.type = 'number';
            input1.name = 'dole_driver';
            input1.classList.toggle('form-control');
            var label1 = document.createElement('label');
            label1.classList.toggle('text-semibold');
            label1.innerText = "Доля водителя в процентах:";
            label1.setAttribute('style', 'margin-top: 1em;');

            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(label1);
            div.appendChild(input1);
        }

        function km() {
            var div = document.getElementById('add');
            var input = document.createElement('input');
            input.type = 'number';
            input.name = 'km';

            input.classList.toggle('form-control');
            var label = document.createElement('label');
            label.classList.toggle('text-semibold');
            label.innerText = "Километры:";
            label.setAttribute('style', 'margin-top: 1em;');

            var input1 = document.createElement('input');
            input1.type = 'number';
            input1.name = 'tg';
            input1.classList.toggle('form-control');
            var label1 = document.createElement('label');
            label1.classList.toggle('text-semibold');
            label1.innerText = "Тенге:";
            label1.setAttribute('style', 'margin-top: 1em;');

            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(label1);
            div.appendChild(input1);
        }

    });
</script>