<script type="text/javascript" src="/profile/files/js/mytables/stats/tp.js"></script>

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
                            <th>Название таксопарка</th>
                            <th>Название компании</th>
                            <th>Регион</th>
                            <th>Контактный email</th>
                            <th>№, дата договора Срок окончания договора</th>
                            <th>Монеты</th>
                            <th>Собственные автомобили</th>
                            <th>Арендованные автомобили</th>
                            <th>Смешанные автомобили</th>
                            <th>Тип №</th>
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

