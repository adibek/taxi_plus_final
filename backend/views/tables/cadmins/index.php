<script type="text/javascript" src="/profile/files/js/mytables/cadmins/index.js"></script>

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
                            <th>Название компании</th>
                            <th>Регионы</th>
                            <th>Ф.И.О.</th>
                            <th>email</th>
                            <th>Дата регистрации</th>
                            <th>Монеты</th>
                            <th>Телефон</th>
                            <th>Сотрудники</th>
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

