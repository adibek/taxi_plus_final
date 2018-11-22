<?php use backend\components\Helpers;
use backend\models\Users;
?>

<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
            <li class="navigation-header"><span>Администрирование</span> <i class="icon-menu" title="Администрирование"></i></li>

           <? if(Yii::$app->session->get('profile_role') == 9) {
               ?>
               <li class="nav-item"><a id = "admins" href="admins" class = "cs-link"><i class="icon-users"></i>Администраторы</a></li>
               <li class="nav-item"><a id = "orders" href="orders" class = "cs-link"><i class="icon-car"></i>Лента заказов</a></li>
               <li class="nav-item"><a id = "admins/moderators" data-id="0"  class="action-link" href="admins/moderators"><i class="icon-user-check"></i>Модераторы</a></li>
               <li class="nav-item"><a id = "taxi-parks" href="taxi-parks" class = "cs-link"><i class="icon-office"></i>Таксопарки</a></li>
               <li class="nav-item"><a id = "tadmins" href="tadmins" class = "cs-link"><i class="icon-users2"></i>Администраторы таксопарков</a></li>
               <li class="nav-item"><a id = "companies" href="companies" class = "cs-link"><i class="icon-home7"></i>Компании</a></li>
               <li class="nav-item"><a id = "cadmins" href="cadmins" class = "cs-link"><i class="icon-users4"></i>Администраторы компаний</a></li>



                <li>
                    <a href="#"><i class="icon-statistics"></i> <span>Статистика</span></a>
                    <ul>
                        <li class="nav-item" ><a id = "stats-orders" href="stats-orders" class = "cs-link">По заказам</a></li>
                        <li class="nav-item" ><a id = "stats-referals" href="stats-referals" class = "cs-link">По рефералам</a></li>
                        <li class="nav-item" ><a id = "stats-drivers" href="stats-drivers" class = "cs-link">По водителям</a></li>
                        <li class="nav-item" ><a id = "stats-clients" href="stats-clients" class = "cs-link">По клиентам</a></li>
                        <li class="nav-item" ><a id = "stats-tp" href="stats-tp" class = "cs-link">По таксопаркам</a></li>
                        <li class="nav-item" ><a id = "stats-companies" href="stats-companies" class = "cs-link">По компаниям</a></li>

                    </ul>
                </li>
               <li class="nav-item"><a id = "traffic" href="traffic" class = "cs-link"><i class="icon-cash2"></i> Оборот монет </a></li>


               <?
           }elseif (Yii::$app->session->get('profile_role') == 3){
               ?>

               <li class="nav-item"><a id = "orders" href="orders" class = "cs-link"><i class="icon-car"></i>Лента заказов</a></li>
               <li class="nav-item"><a id = "admins/moderators" data-id="0"  class="action-link" href="admins/moderators"><i class="icon-user-check"></i>Модераторы</a></li>
               <li class="nav-item"><a id = "taxi-parks" href="taxi-parks" class = "cs-link"><i class="icon-office"></i>Таксопарки</a></li>
               <li class="nav-item"><a id = "tadmins" href="tadmins" class = "cs-link"><i class="icon-users2"></i>Администраторы таксопарков</a></li>
               <li class="nav-item"><a id = "companies" href="companies" class = "cs-link"><i class="icon-home7"></i>Компании</a></li>
               <li class="nav-item"><a id = "cadmins" href="cadmins" class = "cs-link"><i class="icon-users4"></i>Администраторы компаний</a></li>



               <li>
                   <a href="#"><i class="icon-statistics"></i> <span>Статистика</span></a>
                   <ul>
                       <li class="nav-item" ><a id = "stats-orders" href="stats-orders" class = "cs-link">По заказам</a></li>
                       <li class="nav-item" ><a id = "stats-referals" href="stats-referals" class = "cs-link">По рефералам</a></li>
                       <li class="nav-item" ><a id = "stats-drivers" href="stats-drivers" class = "cs-link">По водителям</a></li>
                       <li class="nav-item" ><a id = "stats-clients" href="stats-clients" class = "cs-link">По клиентам</a></li>
                       <li class="nav-item" ><a id = "stats-tp" href="stats-tp" class = "cs-link">По таксопаркам</a></li>
                       <li class="nav-item" ><a id = "stats-companies" href="stats-companies" class = "cs-link">По компаниям</a></li>

                   </ul>
               </li>
               <li class="nav-item"><a id = "traffic" href="traffic" class = "cs-link"><i class="icon-cash2"></i> Оборот монет </a></li>


               <?

           }elseif (Helpers::getMyRole() == 4){
               ?>
               <li class="nav-item"><a id = "orders" href="orders" class = "cs-link"><i class="icon-car"></i>Лента заказов</a></li>
               <li class="nav-item"><a id = "drivers" href="drivers" class = "cs-link"><i class="icon-car2"></i>Водители </a></li>
               <li class="nav-item"><a id = "users" href="users" class = "cs-link"><i class="icon-users4"></i>Клиенты</a></li>
               <?
           }elseif (Helpers::getMyRole() == 5){
                ?>

               <li class="nav-item"><a id = "orders" href="orders" class = "cs-link"><i class="icon-car"></i>Лента заказов</a></li>
               <li class="nav-item"><a id = "moderators" href="moderators" class = "cs-link"><i class="icon-user-check"></i>Модераторы</a></li>
               <li class="nav-item"><a id = "dispatchers" href="dispatchers" class = "cs-link"><i class="icon-user-check"></i>Диспетчеры</a></li>
               <li class="nav-item"><a id = "drivers" href="drivers" class = "cs-link"><i class="icon-car2"></i>Водители </a></li>
               <li class="nav-item"><a id = "users" href="users" class = "cs-link"><i class="icon-users4"></i>Клиенты</a></li>

               <li>
                   <a href="#"><i class="icon-statistics"></i> <span>Статистика</span></a>
                   <ul>
                       <li class="nav-item" ><a id = "stats-orders" href="stats-orders" class = "cs-link">По заказам</a></li>
                       <li class="nav-item" ><a id = "stats-referals" href="stats-referals" class = "cs-link">По рефералам</a></li>
                       <li class="nav-item" ><a id = "stats-drivers" href="stats-drivers" class = "cs-link">По водителям</a></li>
                       <li class="nav-item" ><a id = "stats-clients" href="stats-clients" class = "cs-link">По клиентам</a></li>
                   </ul>
               </li>
               <li class="nav-item"><a class="action-link" data-id="<?=Helpers::getMyTaxipark()?>"  href="taxi-parks/form-taxi-park"><i class="icon-office"></i>Настройка таксопарка</a></li>

               <?
           }elseif(Yii::$app->session->get("profile_role") == 7) {
               ?>
               <li class="nav-item"><a id = "coworkers" href="coworkers" class = "cs-link"><i class="icon-cash4"></i>Сотрудники компании</a></li>
               <li class="nav-item"><a data-id=3 data-info="Корпоративный клиент" id = "orders" class="action-link" href="orders/orders-list"><i class="icon-car"></i>Поездки</a></li>
               <?
           }?>




            <?php
                if(Yii::$app->session->get("profile_role") == 52){
                    $drivers_count = count(Users::find()->where(['role_id' => 2])->andWhere(['is_active' => 0])->all());
                    if($drivers_count != 0){
                        $count_drivers_text = '<span class="label bg-orange-400">'. $drivers_count .'</span>';
                    }
                    ?>
                    <li class="nav-item"><a id = "moderators" href="moderators" class = "cs-link"><i class="icon-user-check"></i>Модераторы</a></li>
                    <li class="nav-item"><a id = "admins" href="admins" class = "cs-link"><i class="icon-users"></i>Администраторы</a></li>
                    <li class="nav-item"><a id = "tadmins" href="tadmins" class = "cs-link"><i class="icon-users2"></i>Администраторы таксопарков</a></li>
                    <li class="nav-item"><a id = "cadmins" href="cadmins" class = "cs-link"><i class="icon-users4"></i>Администраторы КК</a></li>
                    <li class="nav-item"><a id = "dispatchers" href="dispatchers" class = "cs-link"><i class="icon-headset"></i>Диспетчеры</a></li>

                    <li class="nav-item"><a id = "companies" href="companies" class = "cs-link"><i class="icon-home7"></i>Компании</a></li>

                    <li class="nav-item"><a id = "taxi-parks" href="taxi-parks" class = "cs-link"><i class="icon-office"></i>Таксопарки</a></li>
                    <li class="nav-item"><a id = "drivers" href="drivers" class = "cs-link"><i class="icon-car2"></i>Водители <?=$count_drivers_text?></a></li>
                    <li class="nav-item"><a id = "orders" href="orders" class = "cs-link"><i class="icon-car"></i>Поездки</a></li>

                    <li class="nav-item"><a id = "users" href="users" class = "cs-link"><i class="icon-users4"></i>Клиенты</a></li>


                    <?php
                }
            ?>
            <?php
            if(Yii::$app->session->get("profile_role") == 6){
                ?>
                <li class="nav-item"><a id = "cashier" href="cashier" class = "cs-link"><i class="icon-price-tag"></i>Пополнение баланса таксопарков</a></li>
                <?php
            }


            ?>
            <?php
            if(Yii::$app->session->get("profile_role") == 52) {
                ?>
                <li class="nav-item"><a id = "dispatchers" href="dispatchers" class = "cs-link"><i class="icon-users4"></i>Диспетчеры</a></li>
                <li class="nav-item"><a id = "taxi-parks" href="taxi-parks" class = "cs-link"><i class="icon-office"></i>Таксопарки</a></li>
                <li>
                    <a href="#"><i class="icon-lock2"></i> <span>Покупка</span></a>
                    <ul>
                        <li><a id="" href="" class="cs-link">Пополнть счет</a></li>
                        <li><a id="access" href="access" class="cs-link">Доступ к общему чату </a></li>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if(Yii::$app->session->get("profile_role") == 11){
                ?>
<!--                <li class="nav-item"><a id = "traffic" href="traffic" class = "cs-link"><i class="icon-office"></i>Оборот монет</a></li>-->
                <li class="nav-item"><a id = "cashiers" href="cashiers" class = "cs-link"><i class="icon-cash4"></i>Кассиры</a></li>
                <li class="nav-item"><a id = "settings" href="settings" class = "cs-link"><i class="icon-gear"></i>Настройки</a></li>
                <li class="nav-item"><a id = "price" href="price" class = "cs-link"><i class="icon-price-tag"></i>Просмотр цен</a></li>
                <li class="nav-item"><a id = "traffic" href="traffic" class = "cs-link"><i class="icon-statistics"></i>Оборот монет</a></li>

                <?php
            }
            ?>

            <?php
            if(Yii::$app->session->get("profile_role") == 8){
                ?>

                <li class="nav-item"><a id = "add_order" href="add_order" class = "cs-link"><i class="icon-car"></i>Добавить заказ</a></li>


                <?

            }
            ?>
        </ul>
    </div>

</div>

<script>
    window.onload = function() {
         timedText();
    };

    function timedText() {
        setTimeout(myTimeout1, 2000)
    }
    function myTimeout1() {

        timedText()
    }

</script>