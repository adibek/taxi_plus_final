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
<!--<script type="text/javascript" src="/profile/files/js/mytables/drivers/form.js"></script>-->
<!--<script type="text/javascript" src="/profile/files/js/mytables/coworkers/aindex.js"></script>-->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>

<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <label class="text-semibold">Введите номер телефона пользователя для поиска без '+', '8' и т.д. (Пример: 77058972548):</label>
                    <input type="number" class="form-control mt-5" id="phone" placeholder="77059782548">
                    <button onclick="search()" class="btn btn-success mt-15" type="button">Поиск</button>
                    <div id="results" class="col-md-12 mt-20">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var id = 0;
    function search() {
        var val = document.getElementById('phone').value;
        $.ajax({
            type: "POST",
            url: "/profile/company/search/",
            data: {phone: val},
            success: function (data) {
                console.log(data);
                if(data.users.length == 0){
                    SendSwal('Ничего не найдено', 'error')
                }
                var div = document.getElementById('results');
                var label = document.createElement('h3');
                // label.classList.toggle('text-semibold');
                label.innerText = 'Имя: ' + data.users[0].name + '\nТелефон: ' + data.users[0].phone;
                id = data.users[0].id;
                var button = document.createElement('button');
                button.classList.toggle('btn');
                button.setAttribute('onclick', 'addUser()');
                button.innerText = 'Присоединить сотрудника';
                div.appendChild(label);
                div.appendChild(button);
            },
        });
    }
    function addUser() {
        $.ajax({
            type: "POST",
            url: "/profile/company/add-user/",
            data: {id: id},
            success: function (data) {
                if(data.type == 'success'){
                    SendSwal('Сотрудник успешно добавлен', 'success', 'coworkers')
                }else{
                    SendSwal('Ошибка, обратитесь к администратору приложения', 'error', 'coworkers')
                }
            },
        });
    }
    function SendSwal(message, type, link) {
        swal({
            title: message,
            timer: 900,
            type: type,
            showConfirmButton: false
        });
        if (link != null) {
            $('#' + link).trigger('click');
        }

    }
</script>