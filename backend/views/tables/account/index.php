<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<script type="text/javascript" src="/profile/files/js/cronos/forms.js"></script>

<?=$this->render('/layouts/header/_header')?>

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <form id = "form_information">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Личная информация</h5>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-semibold">E-Mail адрес:</label>
                            <div class="form-control-static"><?=$model->email?></div>
                        </div>
                        <div class="form-group">
                            <label class = "text-semibold">Ф.И.О:</label>
                            <input name="_csrf-backend" type="hidden" class="form-control" value = "<?=Yii::$app->getRequest()->getCsrfToken()?>">
                            <input type="text" name = "Information[name]" class="form-control" value = "<?=$model->name?>" required = "required" placeholder="Ваше Ф.И.О">
                        </div>
                        <div class="form-group">
                            <label class = "text-semibold">Номер телефона:</label>
                            <input type="text" name = "Information[phone]" class="form-control" value = "<?=$model->phone?>" required = "required" placeholder="Ваш телефон">
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label class="display-block text-semibold">Изображение:</label>-->
<!--                            --><?// if ($model->avatar != null) { ?>
<!--                                <div class="form-group">-->
<!--                                    <img class = "account_avatar" width = "100" src = "uploads/associate/--><?//=$model->avatar?><!--" />-->
<!--                                </div>-->
<!--                            --><?// } ?>
<!--                            <input type="file" name = "avatar" accept="image/*" class="file-styled">-->
<!--                            <span class="help-block">Разрешенные форматы: gif, png, jpg.</span>-->
<!--                        </div>-->
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <form id = "form_security">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Безопасность</h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-semibold">Текущий пароль:</label>
                            <input name="_csrf-backend" type="hidden" class="form-control" value = "<?=Yii::$app->getRequest()->getCsrfToken()?>">
                            <input type="password" name = "password" class="form-control" required = "required">
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Новый пароль:</label>
                            <input type="password" id = "newpass" name = "newpass" class="form-control" required = "required">
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Повторите новый пароль:</label>
                            <input type="password" name = "repeat_newpass" class="form-control" required = "required">
                        </div>
                        <div class="text-right">
                            <button id = "setpassword" type="submit" class="btn btn-primary">Изменить пароль <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>