<?php
use backend\models\TaxiPark;
?>
<!-- ENGINE -->
<script type="text/javascript" src="/profile/files/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/profile/files/js/pages/form_layouts.js"></script>



<?=$this->render("/layouts/header/_header", array("model" => $model))?>

<div class="content">
    <form id = "form">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="col-md-12">
                    <label class="text-semibold">Координаты точки А</label>
                    <input id="lata" required type = text value="43.240460">
                    <input id="longa" required type = text value="76.923910">

                    <label class="text-semibold">Координаты точки Б</label>
                    <input id="latb" required type = text value="43.194601">
                    <input id="longb" required type = text value="76.887045">
                    <?
                        $list = TaxiPark::find()->all();
                    ?>
<!--                    <div class="col-md 6">-->
<!--                        <label class="text-semibold">Таксопарк</label>-->
<!--                        <select required name = "taxi_park_id" class="select">-->
<!--                            <option value="0">Не выбран (Taxi+)</option>-->
<!--                            --><?// foreach ($list as $key => $value) { ?>
<!--                                <option value="--><?//=$value->id?><!--">--><?//=$value->name?><!--</option>-->
<!--                            --><?// } ?>
<!--                        </select>-->
<!--                    </div>-->
                    <div id="result" class="col-md-6">

                    </div>
                </div>
                <div class="text-right">
                    <a type="button" onclick="submit()">Рассчитать</a>
                </div>

            </div>
        </div>
    </form>
</div>
<script>
    function submit() {
        var lata = document.getElementById('lata').value;
        var longa = document.getElementById('longa').value;
        var latb = document.getElementById('latb').value;
        var longb = document.getElementById('longb').value;
        var res = document.getElementById('result');
        res.innerHTML = "";
        $.ajax({url: "account/get-price/",
            method: 'POST',
            data: {
                longitude_a: longa,
                latitue_a: lata,
                lotitude_b: latb,
                longitude_b: longb,
                token: 12
            },
            success: function(result) {
                console.log(result);
                var res = document.getElementById('result');
                for(var i = 0; i < result.price_list.length; i++){
                    var div = document.createElement('div');
                    div.classList.toggle('col-md-6');
                    var div2 = document.createElement('div');
                    div2.classList.toggle('col-md-6');
                    var lbl = document.createElement('label');
                    lbl.classList.toggle('text-semibold');
                    lbl.innerHTML = 'Услуга: ' + result.price_list[i].service + '   ';
                    var prc = document.createElement('label');
                    prc.classList.toggle('text-semibold');
                    prc.innerHTML = '  Цена: ' + Math.round(result.price_list[i].price);
                    div.appendChild(lbl);
                    div2.appendChild(prc);
                    res.appendChild(div);
                    res.appendChild(div2);
                }
            }
        });
    }

</script>