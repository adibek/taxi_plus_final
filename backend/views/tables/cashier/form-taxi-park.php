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
<script type="text/javascript" src="/profile/files/js/mytables/cashier/form.js"></script>
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

<!--                        --><?//=$this->render('/layouts/modal-components/_input', array('info' => array("Название", "name", "text", $model->name, "true")))?>
                        <label class = "text-semibold">Название:</label>
                        <input value="<?=$model->name?>" disabled class="form-control" >
                        <?
                        $list = WorkingTypes::find()->all();
                        $cities = Cities::find()->all();
                        ?>
                        <label class = "text-semibold">Тип оплаты:</label>
                        <select disabled name = "payment" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($list as $key => $value) { ?>
                                <option <? if ($value->id == $model->type) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->description?></option>
                            <? } ?>
                        </select>


                        <label class = "text-semibold">Город:</label>
                        <select disabled name = "city_id" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($cities as $key => $value) { ?>
                                <option <? if ($value->id == $model->city_id) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->cname?></option>
                            <? } ?>
                        </select>


                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Баланс таксопарка", "balance", "number", $model->balance, "true")))?>

                    </div>

                    <div class = "col-md-12">

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
        $("[name='access']").bootstrapSwitch();



    });

    function deleteDiv(rand){
        document.getElementById('bigDiv' + rand).remove();
    }

    function appendCircle(rand){
        var random =  Math.floor(Math.random() * 30) + 1;
        var radiusDiv = document.createElement('div');
        radiusDiv.classList.toggle('col-md-6');
        var tengeDiv = document.createElement('div');
        tengeDiv.classList.toggle('col-md-6');

        var radiusLabel = document.createElement("label");
        radiusLabel.classList.toggle("text-semibold");
        radiusLabel.innerHTML = "Ширина круга в метрах(диаметр):";
        var tengeLabel = document.createElement("label");
        tengeLabel.classList.toggle("text-semibold");
        tengeLabel.innerHTML = "Цена внутри круга в тенге";

        var radiusInput = document.createElement("input");
        radiusInput.name = "meters[" + rand + "][" + random + "]";
        radiusInput.classList.toggle("form-control");
        radiusInput.required = true;
        radiusInput.type = 'number';
        radiusInput.placeholder = "500";
        var tengeInput = document.createElement("input");
        tengeInput.name = "tenge[" + rand + "][" + random + "]";
        tengeInput.classList.toggle("form-control");
        tengeInput.required = true;
        tengeInput.placeholder = "600";
        tengeInput.type = 'number';

        radiusDiv.appendChild(radiusLabel);
        radiusDiv.appendChild(radiusInput);
        tengeDiv.appendChild(tengeLabel);
        tengeDiv.appendChild(tengeInput);

        document.getElementById('radial' + rand).appendChild(radiusDiv);
        document.getElementById('radial' + rand).appendChild(tengeDiv);

    }

    function appendKm(rand) {

        var kilometerDiv = document.createElement('div');
        kilometerDiv.classList.toggle('col-md-12');
        kilometerDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em;");
        kilometerDiv.id = 'km' + rand;
        var callDiv = document.createElement('div');
        callDiv.classList.toggle('col-md-6');
        var kmDiv = document.createElement('div');
        kmDiv.classList.toggle('col-md-6');

        var callLabel = document.createElement("label");
        callLabel.classList.toggle("text-semibold");
        callLabel.innerHTML = "Цена за вызов в тенге:";
        var kmLabel = document.createElement("label");
        kmLabel.classList.toggle("text-semibold");
        kmLabel.innerHTML = "Цена за километр в тенге:";

        var callInput = document.createElement("input");
        callInput.name = "call[" + rand + "]";
        callInput.classList.toggle("form-control");
        callInput.required = true;
        callInput.type = 'number';
        callInput.placeholder = "150";
        var kmInput = document.createElement("input");
        kmInput.name = "km[" + rand + "]";
        kmInput.classList.toggle("form-control");
        kmInput.required = true;
        kmInput.type = 'number';
        kmInput.placeholder = "100";

        callDiv.appendChild(callLabel);
        callDiv.appendChild(callInput);
        kmDiv.appendChild(kmLabel);
        kmDiv.appendChild(kmInput);

        kilometerDiv.appendChild(callDiv);
        kilometerDiv.appendChild(kmDiv);

        var bigDiv = document.getElementById('bigDiv' + rand);
        bigDiv.appendChild(kilometerDiv);

        $('[name="access[' + rand + ']"]').bootstrapSwitch();
        $('[name="service[' + rand + ']"]').select2();

    }

    function appendRadial(rand) {
        var random =  Math.floor(Math.random() * 30) + 1;
        var radialDiv = document.createElement('div');
        radialDiv.classList.toggle('col-md-12');
        radialDiv.id = 'radial' + rand;
        radialDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em;");
        var radiusDiv = document.createElement('div');
        radiusDiv.classList.toggle('col-md-3');
        var tengeDiv = document.createElement('div');
        tengeDiv.classList.toggle('col-md-3');
        var kmDiv = document.createElement('div');
        kmDiv.classList.toggle('col-md-3');
        var buttonDiv = document.createElement('div');
        buttonDiv.classList.toggle('col-md-3');



        var kmLabel = document.createElement("label");
        kmLabel.classList.toggle("text-semibold");
        kmLabel.innerHTML = "Цена за километр в тенге:";

        var kmInput = document.createElement("input");
        kmInput.name = "km[" + rand + "]";
        kmInput.classList.toggle("form-control");
        kmInput.required = true;
        kmInput.type = 'number';
        kmInput.placeholder = "100";


        var radiusLabel = document.createElement("label");
        radiusLabel.classList.toggle("text-semibold");
        radiusLabel.innerHTML = "Ширина круга в метрах(диаметр):";
        var tengeLabel = document.createElement("label");
        tengeLabel.classList.toggle("text-semibold");
        tengeLabel.innerHTML = "Цена внутри круга в тенге";

        var radiusInput = document.createElement("input");
        radiusInput.name = "meters[" + rand + "][" + random + "]";
        radiusInput.classList.toggle("form-control");
        radiusInput.required = true;
        radiusInput.type = 'number';
        radiusInput.placeholder = "500";
        var tengeInput = document.createElement("input");
        tengeInput.name = "tenge[" + rand + "][" + random + "]";
        tengeInput.classList.toggle("form-control");
        tengeInput.required = true;
        tengeInput.placeholder = "600";
        tengeInput.type = 'number';

        var a = '<button type="button" class="btn btn-primary" onclick="appendCircle(' + rand +')"> Добавить круг </button>';

        radiusDiv.appendChild(radiusLabel);
        radiusDiv.appendChild(radiusInput);
        tengeDiv.appendChild(tengeLabel);
        tengeDiv.appendChild(tengeInput);
        kmDiv.appendChild(kmLabel);
        kmDiv.appendChild(kmInput);

        radialDiv.appendChild(radiusDiv);
        radialDiv.appendChild(tengeDiv);
        radialDiv.appendChild(kmDiv);
        buttonDiv.classList.toggle('col-md-6');
        buttonDiv.insertAdjacentHTML('beforeend', a);
        buttonDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em;");
        radialDiv.appendChild(buttonDiv);

        var bigDiv = document.getElementById('bigDiv' + rand);
        bigDiv.appendChild(radialDiv);



    }

    function trya(id) {
        var switc = document.getElementById(id);
        var is_km = $('#' + id).bootstrapSwitch('state');
        var bigDiv = document.getElementById('bigDiv' + id);

        if(is_km){
            var radial = document.getElementById('radial' + id).remove();
            appendKm(id);
        }else{
            var km = document.getElementById('km' + id).remove();
            appendRadial(id);

        }
    }
    var rands = [];



    function add() {
        $.ajax({url: "services/",
            success: function(result) {
                var array = result.data;
                var rand = result.rand;

                var sw = '<input id="' + rand + '" type="checkbox" name="access[' + rand + ']" checked data-on-color="success" data-off-color="danger" data-on-text="Километражный" data-off-text="Радиальный" onchange="trya('+ rand +')" class="switch" style="padding-top: 5em;">';
                var myDiv = document.getElementById("addings");

                var bigDiv = document.createElement('div');
                bigDiv.classList.toggle('col-md-12');
                bigDiv.id = 'bigDiv' + rand;
                bigDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em; margin-top: 2em; border:0.5px solid lightslategray;");

                var typeLabel = document.createElement('label');
                typeLabel.classList.toggle("text-semibold");
                typeLabel.innerText = 'Режим работы:';

                var selectList = document.createElement("select");
                selectList.classList.toggle("select");
                selectList.id = "mySelect";
                selectList.name = "service[" + rand + "]";
                for (var i = 0; i < array.length; i++) {
                    var option = document.createElement("option");
                    option.value = array[i].id;
                    option.text = array[i].value;
                    selectList.appendChild(option);
                }

                var selectDiv = document.createElement('div');
//                selectDiv.id = rand;
                selectDiv.classList.toggle('col-md-12');
                selectDiv.appendChild(typeLabel);
                selectDiv.appendChild(selectList);
                var subSelectDiv = document.createElement('div');
                subSelectDiv.classList.toggle('col-md-6');
                subSelectDiv.insertAdjacentHTML('beforeend', sw);
                subSelectDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em;");

                selectDiv.appendChild(subSelectDiv);



                var sessionDiv = document.createElement('div');
                sessionDiv.classList.toggle('col-md-12');

                var limDiv = document.createElement('div');
                limDiv.classList.toggle('col-md-4');
                var limLabel = document.createElement("label");
                limLabel.classList.toggle("text-semibold");
                limLabel.innerHTML = "Стоимость открытия смены на 6 часов:";
                var limInput = document.createElement("input");
                limInput.name = "session_price[" + rand + "]";
                limInput.classList.toggle("form-control");
                limInput.placeholder = "1200";
                limInput.required = true;
                limInput.type = 'number';

                limDiv.appendChild(limLabel);
                limDiv.appendChild(limInput);

                var unlimDiv = document.createElement('div');
                unlimDiv.classList.toggle('col-md-4');
                var unlimLabel = document.createElement("label");
                unlimLabel.classList.toggle("text-semibold");
                unlimLabel.innerHTML = "Стоимость открытия смены на 12 часов:";
                var unlimInput = document.createElement("input");
                unlimInput.name = "session_price_unlim[" + rand + "]";
                unlimInput.classList.toggle("form-control");
                unlimInput.placeholder = "2000";
                unlimInput.required = true;
                unlimInput.type = 'number';
                unlimDiv.appendChild(unlimLabel);
                unlimDiv.appendChild(unlimInput);

                var percentDiv = document.createElement('div');
                percentDiv.classList.toggle('col-md-4');
                var percentLabel = document.createElement("label");
                percentLabel.classList.toggle("text-semibold");
                percentLabel.innerHTML = "Коммиссия для водителя в процентах:";
                var percentInput = document.createElement("input");
                percentInput .name = "percent[" + rand + "]";
                percentInput .classList.toggle("form-control");
                percentInput .required = true;
                percentInput.placeholder = "8";
                percentInput .type = 'number';
                percentDiv.appendChild(percentLabel);
                percentDiv.appendChild(percentInput);



                sessionDiv.appendChild(limDiv);
                sessionDiv.appendChild(unlimDiv);
                sessionDiv.appendChild(percentDiv);

                var kilometerDiv = document.createElement('div');
                kilometerDiv.classList.toggle('col-md-12');
                kilometerDiv.setAttribute("style", "padding-top: 2em; padding-bottom: 2em;");
                kilometerDiv.id = 'km' + rand;
                var callDiv = document.createElement('div');
                callDiv.classList.toggle('col-md-6');
                var kmDiv = document.createElement('div');
                kmDiv.classList.toggle('col-md-6');

                var callLabel = document.createElement("label");
                callLabel.classList.toggle("text-semibold");
                callLabel.innerHTML = "Цена за вызов в тенге:";
                var kmLabel = document.createElement("label");
                kmLabel.classList.toggle("text-semibold");
                kmLabel.innerHTML = "Цена за километр в тенге:";

                var callInput = document.createElement("input");
                callInput.name = "call[" + rand + "]";
                callInput.classList.toggle("form-control");
                callInput.required = true;
                callInput.type = 'number';
                callInput.placeholder = "150";
                var kmInput = document.createElement("input");
                kmInput.name = "km[" + rand + "]";
                kmInput.classList.toggle("form-control");
                kmInput.required = true;
                kmInput.type = 'number';
                kmInput.placeholder = "100";

                callDiv.appendChild(callLabel);
                callDiv.appendChild(callInput);
                kmDiv.appendChild(kmLabel);
                kmDiv.appendChild(kmInput);


                kilometerDiv.appendChild(callDiv);
                kilometerDiv.appendChild(kmDiv);
//                kilometerDiv.appendChild(percentDiv);

                bigDiv.appendChild(selectDiv);
                bigDiv.appendChild(sessionDiv);
                bigDiv.appendChild(kilometerDiv);
                var deleteDiv = document.createElement('div');
                deleteDiv.classList.toggle('text-right');
                deleteDiv.setAttribute("style", "padding-top: 3em;");
                var a = '<button type="button" class="btn btn-danger" onclick="deleteDiv(' + rand +')">Удалить</button>';
                deleteDiv.insertAdjacentHTML('beforeend', a);
                bigDiv.appendChild(deleteDiv);
//                bigDiv.appendChild(radialDiv);
                myDiv.appendChild(bigDiv);
                $('[name="access[' + rand + ']"]').bootstrapSwitch();
                $('[name="service[' + rand + ']"]').select2();


            }
        });


    }


</script>