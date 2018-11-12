<?php
    use backend\assets\AppAsset;
    use backend\components\Helpers;
    use yii\helpers\Html;
    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body>
        <?php $this->beginBody() ?>
            <?php if (Yii::$app->controller->action->id != "authentication") { ?>
                <? Helpers::CheckAuth("no-redirect", null); ?>
                <div class="navbar navbar-default header-highlight">
                    <div class="navbar-header">

                        <a class="navbar-brand" style = "color:#000; background-color: #F2DD26" >Taxi Plus</a>
                        <?php

                        if(Yii::$app->session->get("company_id") == null){
                            if(Yii::$app->session->get("profile_tp") != 0){
                                $me = \backend\models\Users::find()->where(['id' => Yii::$app->session->get("profile_id")])->one();
                                $taxi_park = \backend\models\TaxiPark::find()->where(['id' => $me->taxi_park_id])->one();
                                $balance = 'Баланс таксопарка: ' . $taxi_park->balance;
                            }

                        }else{

                            $company = \backend\models\Company::find()->where(['id' => Yii::$app->session->get('company_id')])->one();
                            $balance = 'Баланс компании: ' . $company->balance;

                        }

                        ?>
                        <? if(Yii::$app->session->get("profile_tp") != 0) {?>
                        <a id="demo" class="navbar-brand" style = "color:#000; background-color: #B3FFCD" href="javascript:void(0);"><?=$balance?> монет</a>
                        <? }?>
                        <ul class="nav navbar-nav visible-xs-block">
                            <li><a data-toggle="collapse" data-target="#navbar-mobile" class="legitRipple"><i class="icon-tree5"></i></a></li>
                            <li><a class="sidebar-mobile-main-toggle legitRipple"><i class="icon-paragraph-justify3"></i></a></li>
                        </ul>
                    </div>

                    <div class="navbar-collapse collapse" id="navbar-mobile">
                        <ul class="nav navbar-nav">
                            <li><a class="sidebar-control sidebar-main-toggle hidden-xs legitRipple"><i class="icon-paragraph-justify3"></i></a></li>

                        </ul>


                    </div>
                </div>
                <div class="page-container">
                    <div class="page-content">
                        <div class="sidebar sidebar-main">
                            <div class="sidebar-content">
                                <div class="sidebar-user-material">
                                    <div class="category-content">
                                        <div class="sidebar-user-material-content">
                                            <a href="account" class = "cs-link"><img src="/profile/uploads/associate/<?=Yii::$app->session->get('profile_avatar')?>" class="account_avatar img-responsive" alt=""></a>
                                            <h6><?=Yii::$app->session->get('profile_fio')?></h6>
                                            <span class="text-size-small text-muted"><?=$roles[Yii::$app->session->get('profile_role')]?></span>
                                        </div>

                                        <div class="sidebar-user-material-menu">
                                            <a href="#user-nav" data-toggle="collapse"><span>Мой профиль</span> <i class="caret"></i></a>
                                        </div>
                                    </div>

                                    <div class="navigation-wrapper collapse" id="user-nav">
                                        <ul class="navigation">
                                            <li><a href="account" class = "cs-link"><i class="icon-cog5"></i> <span>Настройки аккаунта</span></a></li>
                                            <li><a href="/profile/logout/"><i class="icon-switch2"></i> <span>Выход</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?=$this->render('/layouts/mainmenu')?>
                            </div>
                        </div>
                        <div id = "dynamic_content" class="content-wrapper"></div>
                    </div>
                </div>
            <?php } else { ?>
                <?=$this->render('/layouts/authentication'); ?>
            <?php } ?>
        <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>

<script>
    window.onload = function() {
      //  timedText();
    };

    function timedText() {
        setTimeout(myTimeout1, 2000)
    }
    function myTimeout1() {

        $.ajax({url: "site/drivers/",
            success: function(result){
            if(result.count > 0){
                document.getElementById("drivers").innerHTML = "<i class='icon-office'></i>Водители: " + "<span class='label bg-orange-400'>" + result.count + "</span>";
            }else{
                document.getElementById("drivers").innerHTML = "<i class='icon-office'></i>Водители: </span>";
            }

            }
        });
        $.ajax({url: "site/balance/",
            success: function(result){
                document.getElementById("demo").innerHTML = "Баланс: " + result.balance +" монет";
            }
        });
        timedText()
    }

</script>