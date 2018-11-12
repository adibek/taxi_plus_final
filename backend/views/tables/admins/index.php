<script type="text/javascript" src="/profile/files/js/mytables/admins/index.js"></script>

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
                            <th>Регионы</th>
                            <th>ФИО</th>
                            <th>email</th>
                            <th>Дата Регистрации</th>
                            <th>Телефон</th>
                            <th>Количество водителей</th>
                            <th>Количество клиентов</th>
                            <th>Модераторы</th>
                            <th>Просмотр</th>
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

