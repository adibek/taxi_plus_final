<?php
use backend\models\Privileges;
use backend\models\Cities;
use backend\models\TaxiParkServices;
use backend\models\Services;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>
<script type="text/javascript" src="/profile/files/js/cronos/forms.js"></script>

<!---LOCAL --->
<script type="text/javascript" src="/profile/files/js/mytables/settings/form.js"></script>
<!------->

<?=$this->render("/layouts/header/_header", array("model" => $model))?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
                <form id = "form_sec">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">Цены на доступ к общему чату</h5>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <?
                                $prices = Services::find()->all();
                                foreach ($prices as $key => $value){
                                    ?>
                                    <div class="col-md-6">
                                        <label class = "text-semibold">Цена на доступ к общему чату класса <?=$value->value?> (в монетах):</label>
                                        <input id="price<?=$value->id?>" name="price<?=$value->id?>" class="form-control" placeholder="200" value = "<?=$value->access_price?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class = "text-semibold">Количество монет рефералу клиента для класса <?=$value->value?> (в монетах):</label>
                                        <input id="referal<?=$value->id?>" name="referal<?=$value->id?>" class="form-control" placeholder="5" value = "<?=$value->referal_price?>" required>
                                    </div>
                                        <?
                                }
                                ?>
                                <div class="text-right" style="margin-top: 2em;">
                                    <button onclick="change()"  type="button" class="btn btn-primary">Сохранить <i class="icon-check position-right"></i></button>

                                    <!--                        <a  >Сохранить</a>-->
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
        </div>



    </div>



</div>


<script type="text/javascript">

    function addService() {

        var div = document.getElementById('add');

        swal({
                title: "An input!",
                text: "Write something interesting:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
            function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }

                swal("Nice!", "You wrote: " + inputValue, "success");
            });



    }

    function change() {
        var count = 7;
        var arr = [];
        var arr1 = [];
        for(var i = 1; i<count; i++){
            arr.push($("#price" + i).val());
        }
        for(var i = 1; i<count; i++){
            arr1.push($("#referal" + i).val());
        }
        $.ajax({url: 'site/change-price/',
            method: 'POST',
            data: {price: arr, referal: arr1},
            success: function(result){
                swal({
                    title: 'Цена успешно изменена',
                    timer: 1500,
                    type: 'success',
                    showConfirmButton: true
                });
            }

        });
    }

</script>