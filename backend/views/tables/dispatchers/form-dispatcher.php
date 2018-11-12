<?php
use backend\models\News;
use backend\models\Category;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>

<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/dispatchers/form.js"></script>
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
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("email", "email", "text", $model->email, "true")))?>

                        <?
                            if($model == null){ ?>
                                <?=$this->render('/layouts/modal-components/_input', array('info' => array("Пароль", "password", "text", $model->password, "true")))?>
                            <?
                            }

                            $list = \backend\models\TaxiPark::find()->all();

                        ?>


                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Телефон", "phone", "text", $model->phone, "true")))?>

                    </div>
                    <label class = "text-semibold">Таксопарк:</label>
                    <select name = "tp" class="select" required ="required">
                        <option value="">Не выбран</option>
                        <? foreach ($list as $key => $value) { ?>
                            <option <? if ($value->id == $model->taxi_park_id) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->name?></option>
                        <? } ?>
                    </select>


                    <div class = "col-md-12">
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
