<script type="text/javascript" src="/profile/files/js/mytables/companies/index.js"></script>

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
                            <th>Название</th>
                            <th>Регион</th>
                            <th>Контактный email</th>
                            <th>№ и дата договора </th>
                            <th>Срок окончания договора</th>
                            <th>Ф.И.О. Администратора</th>
                            <th>Монеты</th>
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

