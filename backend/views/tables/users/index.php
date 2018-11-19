<script type="text/javascript" src="/profile/files/js/mytables/users/index.js"></script>
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>

<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?=$this->render('/layouts/header/_filter', array('page' => $page))?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Регион</th>
                            <th>Сот. телефон</th>
                            <th>пол</th>
                            <th>Дата регистрации</th>
                            <th>Рефералы (кол-во)</th>
                            <th>Бонусные монеты</th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

