<?php
use backend\models\Users;
use backend\models\Facilities;
use backend\models\DriversFacilities;
use backend\models\DriversServices;
use backend\models\UsersPrivileges;
use backend\models\TaxiParkPrivileges;
use backend\models\TaxiPark;
use backend\models\CarModels;
use backend\models\Services;

?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<script src="bootstrap-switch.js"></script>
<link href="bootstrap.css" rel="stylesheet">
<link href="bootstrap-switch.css" rel="stylesheet">
<!---LOCAL --->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="/profile/files/js/mytables/drivers/form.js"></script>
<script type="text/javascript" src="/profile/files/js/mytables/coworkers/aindex.js"></script>
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
                            <th>Телефон</th>
                            <th>Создан</th>
                            <th>Добавить</th>
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

