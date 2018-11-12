<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>

<body class="login-container login-cover" style = "background: url('/profile/files/images/bg-auth.png');">
    <div class="page-container">
        <div class="page-content">
            <div class="content-wrapper">
                <div class="content pb-20">
                    <div class="tabbable panel login-form width-400">
                        <div class="tab-content panel-body">
                            <div class="tab-pane fade in active" id="basic-tab1">
                                <form id = "form_login">
                                    <div class="text-center">
<!--                                        <img src="/profile/files/images/logo_light.png" alt="PriceClick" width = "200" style = "margin-right:20px; -webkit-filter: invert(100%); filter: invert(100%);">-->
                                        <h5 class="content-group">Вход в личный кабинет <small class="display-block">Укажите Ваши данные</small></h5>
                                    </div>

                                    <div class="form-group has-feedback has-feedback-left">
                                        <input name="_csrf-backend" type="hidden" class="form-control" value = "<?=Yii::$app->getRequest()->getCsrfToken()?>">
                                        <input type="email" class="form-control" placeholder="Ваш E-Mail адрес" name="email"  required="required">
                                        <div class="form-control-feedback">
                                            <i class="icon-user text-muted"></i>
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback has-feedback-left">
                                        <input type="password" class="form-control" placeholder="Ваш пароль" name="password" required="required">
                                        <div class="form-control-feedback">
                                            <i class="icon-lock2 text-muted"></i>
                                        </div>
                                    </div>

                                    <div class="form-group login-options">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="styled" checked="checked">
                                                    Запомнить меня
                                                </label>
                                            </div>

                                            <div class="col-sm-6 text-right">
                                                <a href="login_password_recover.html">Забыли пароль?</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn bg-indigo-400 btn-block">Войти <i class="icon-arrow-right14 position-right"></i></button>
                                    </div>
                                </form>
                                <span class="help-block text-center no-margin">Нажимая на кнопку войти, вы принимаете <br/><a href="#">условия соглашения</a> и <a href="#">политику cookie</a></span>
                            </div>

                            <div class="tab-pane fade" id="basic-tab2">
                                <form id = "form_registration">
                                    <div class="text-center">
                                        <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                                        <h5 class="content-group">Создание аккаунта <small class="display-block">Заполните все поля</small></h5>
                                    </div>

                                    <div class="form-group has-feedback has-feedback-left">
                                        <input name="_csrf-backend" type="hidden" class="form-control" value = "<?=Yii::$app->getRequest()->getCsrfToken()?>">
                                        <input name="email" type="email" class="form-control" required="required" placeholder="Ваш E-Mail адрес">
                                        <div class="form-control-feedback">
                                            <i class="icon-mention text-muted"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" required="required" class="styled">
                                                Принимаю <a href="#">условия соглашения</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn bg-success btn-block">Регистрация <i class="icon-circle-right2 position-right"></i></button>
                                    </div>
                                </form>
                                <div class="content-divider text-muted form-group"><span>или войти через социальные сети</span></div>
                                <ul class="list-inline form-group list-inline-condensed text-center">
                                    <li><a href="#" class="btn border-indigo text-indigo btn-flat btn-icon btn-rounded"><i class="icon-facebook"></i></a></li>
                                    <li><a href="#" class="btn border-pink-300 text-pink-300 btn-flat btn-icon btn-rounded"><i class="icon-dribbble3"></i></a></li>
                                    <li><a href="#" class="btn border-slate-600 text-slate-600 btn-flat btn-icon btn-rounded"><i class="icon-github"></i></a></li>
                                    <li><a href="#" class="btn border-info text-info btn-flat btn-icon btn-rounded"><i class="icon-twitter"></i></a></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>