<script type="text/javascript" src="/profile/files/js/mytables/cashier/index.js"></script>
<!--<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                   <?=$this->render('/layouts/header/_filter', array('page' => $page))?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Названиие</th>
                            <th>Тип оплаты</th>
                            <th>Баланс</th>
                            <th>Город</th>
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

