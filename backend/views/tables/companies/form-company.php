<?php
use backend\models\News;
use backend\models\Category;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>

<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/companies/form.js"></script>
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
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Контактный email", "name", "email", $model->email, "true")))?>
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("№ договора", "contract_number", "text", $model->contract_number, "false")))?>
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Дата договора", "contract_date", "text", $model->contract_date, "false")))?>
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Срок окончания договора", "contract_end", "text", $model->contract_end, "false")))?>
                        <?
                        if(Yii::$app->session->get('profile_role') == 9){
                            ?>
                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("Баланс", "balance", "number", $model->balance, "true")))?>
                            <?
                        }
                        $cities = \backend\models\Cities::find()->all();
                        ?>

                        <label class = "text-semibold">Город:</label>
                        <select name = "city_id" class="select" required ="required">
                            <option value="">Не выбран</option>
                            <? foreach ($cities as $key => $value) { ?>
                                <option <? if ($value->id == $model->city_id) { ?>selected<? } ?> value="<?=$value->id?>"><?=$value->cname?></option>
                            <? } ?>
                        </select>

                    <div class = "col-md-12 mt-15">
                        <div class="text-right">
                            <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>

                                <a href = "#delete" data-id = "<?=$model->id?>" data-table = "users" data-redirect = "moderators" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>

                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-check position-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
