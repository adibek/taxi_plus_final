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

<!--                        --><?//=$this->render('/layou ts/modal-components/_input', array('info' => array("Название", "name", "text", $model->name, "true")))?>
                        <label class = "text-semibold">Название:</label>
                        <input value="<?=$model->name?>" disabled class="form-control" >
                        <?
                        $list = WorkingTypes::find()->all();
                        $cities = Cities::find()->all();
                        ?>
                        <label class = "text-semibold">Город:</label>
                        <select style="margin-bottom: 1em;" disabled name = "city_id" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($cities as $key => $value) { ?>
                                <option <? if ($value->id == $model->city_id) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->cname?></option>
                            <? } ?>
                        </select>


                        <label class = "text-semibold">Тип оплаты:</label>
                        <select disabled name = "payment" id="type" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($list as $key => $value) { ?>
                                <option <? if ($value->id == $model->type) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->description?></option>
                            <? } ?>
                        </select>


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
    $( document ).ready(function() {
        $( "#type" ).change(function() {
            alert( "Handler for .change() called." );
        });
    });

</script>