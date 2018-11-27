<?php
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<script src="bootstrap-switch.js"></script>
<link href="bootstrap.css" rel="stylesheet">
<link href="bootstrap-switch.css" rel="stylesheet">
<!---LOCAL --->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="/profile/files/js/mytables/messages/form.js"></script>

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
                    </div>
                    <?
                    if($model->id == null){
                        ?>
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Тема сообщения", "title", "text", $model->title, "true")))?>
                        <?=$this->render('/layouts/modal-components/_input', array('info' => array("Текст сообщения", "text", "text", $model->text, "true")))?>
                        <br>
                        <?
                        $roles = \backend\models\Roles::find()->all();
                        $tp = \backend\models\TaxiPark::find()->all();

                        ?>
                        <h2>Получатели</h2>
                        <label class = "text-semibold">Пользователи (роль)</label>
                        <select name = "roles" class="select" required ="required">
                            <option value="0">Все</option>
                            <? foreach ($roles as $key => $value) { ?>
                                <option value="<?=$value->id?>"><?=$value->name?></option>
                            <? } ?>
                        </select>
                        <br>
                        <br>

                        <label class = "text-semibold">Таксопарка</label>
                        <select name = "tps" class="select" required ="required">
                            <option value="000">Всех</option>
                            <? foreach ($tp as $key => $value) { ?>
                                <option value="<?=$value->id?>"><?=$value->name?></option>
                            <? } ?>
                        </select>


                        <div class = "col-md-12" style="margin-top: 2em;">
                            <div class="text-right">


                                <a href = "<?=Yii::$app->request->cookies['back']?>" class="cs-link btn btn-default">Отмена <i class="icon-x position-right"></i></a>
                                <? if ($model->id != null) { ?>
                                    <a href = "#delete" data-id = "<?=$model->id?>" data-table = "users" data-redirect = "admins" class="delete btn btn-danger">Удалить <i class="icon-trash-alt position-right"></i></a>
                                <? } ?>
                                <button type="submit" class="btn btn-primary">Отправить <i class="icon-check position-right"></i></button>
                            </div>
                        </div>
                        <?
                    }else{
                        ?>
                        <h2><?=$model->title?></h2>
                        <br>
                        <br>
                        <label class="text-semibold"><?=$model->text?></label>

                        <?
                    }
                    ?>



                </div>
            </div>
    </form>
</div>


<script>
    $( document ).ready(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "/profile/messages/read-message/",
            data: {id: <?=$model->id?>},
            success: function (data) {
            },
        }).fail(function (xhr) {
            console.log(xhr.responseText);
        });
    });
</script>