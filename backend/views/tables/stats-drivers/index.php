<script type="text/javascript" src="/profile/files/js/mytables/stats/drivers.js"></script>

<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <?=$this->render('/layouts/header/_filter', array('page' => $page))?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Пол</th>
                            <th>Телефон</th>
                            <th>Дата регистрации</th>
                            <th>Марка автомобиля</th>
                            <th>Гос. номер</th>
                            <th>Регион</th>
                            <th>Монеты</th>
                            <th>Средний рейтинг</th>
                            <th></th>
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

