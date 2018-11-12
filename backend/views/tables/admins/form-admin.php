<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>

<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/admins/form.js"></script>
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

                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("Имя", "first_name", "text", $model->first_name, "true")))?>
                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("Фамилия", "last_name", "text", $model->last_name, "true")))?>

                            <?=$this->render('/layouts/modal-components/_input', array('info' => array("email", "email", "text", $model->email, "true")))?>

                        <?
                            if($model == null){ ?>
                                <?=$this->render('/layouts/modal-components/_input', array('info' => array("Пароль", "password", "text", $model->password, "true")))?>
                            <?
                            }
                        ?>


                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Телефон", "phone", "text", $model->phone, "true")))?>


                        <?
                            $admins = \backend\models\SystemUsers::find()->where(['role_id' => 3])->all();
                            $ids = [];
                            foreach ($admins as $k => $v){
                                array_push($ids, $v->id);
                            }
                            $admin_cities = \backend\models\SystemUsersCities::find()->where(['system_user_id' => $ids])->all();
                            $busy_ids = [];
                            foreach ($admin_cities as $k => $v){
                                array_push($busy_ids, $v->city_id);
                            }
                            $its_cities = \backend\models\SystemUsersCities::find()->where(['system_user_id' => $model->id])->all();
                            $my_cities = [];
                            foreach ($its_cities as $k => $v){
                                array_push($my_cities, $v->city_id);
                                foreach ($busy_ids as $key => $value){
                                    if($value == $v->city_id){
                                        unset($busy_ids[$key]);
                                    }
                                }
                            }
                            $cities = \backend\models\Cities::find()->where(['not in','id',$busy_ids])->all();

                        ?>

                        <div class="col-md-6" style="padding-top: 2em; padding-bottom: 2em;">
                            <label class = "text-semibold">Ответственный за город(а):</label>
                            <label class="hint-block">Внимание, если Вы не видите нужного города, вероятно, что у этого города уже есть администратор или этого города еще нет в системе</label>
                            <input type="hidden" id="cities" name="cities">
                            <select id="city" name = "city" class="select" multiple required ="required">
                                <option <? if(!isset($model->id)){ ?>selected<?} ?> value="">Не выбран</option>
                                <? foreach ($cities as $key => $value) { ?>
                                    <option <? if(in_array($value->id, $my_cities)){?>selected<?} ?> value="<?=$value->id?>"><?=$value->cname?></option>
                                <? } ?>
                            </select>
                        </div>

                    </div>

                    <div class = "col-md-12">
                        <div class="text-right">
                            <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>
                            <? if ($model->id != null) { ?>
                                <a href = "#delete" data-id = "<?=$model->id?>" data-table = "system-users" data-redirect = "admins" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>
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
        $(document.body).on("change", "#city", function () {
            var countries = [];
            $.each($("#city option:selected"), function () {
                countries.push($(this).val());
            });
            $('#cities').val(countries);
        });
    });
</script>