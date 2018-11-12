<script type="text/javascript" src="/profile/files/js/mytables/tadmins/index.js"></script>

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
                            <th>Название таксопарка</th>
                            <th>Ф.И.О.</th>
                            <th>email</th>
                            <th>Дата регистрации</th>
                            <th>телефон</th>
                            <th>Кол-во водителей</th>
                            <th>Кол-во клиентов</th>
                            <th>Кол-во модераторов</th>
<!--                            <th>Просмотр</th>-->
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

