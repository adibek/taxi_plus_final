
<script type="text/javascript" src="/profile/files/js/mytables/filtr.js"></script>
<?php
    use backend\components\Helpers;
    use backend\models\Dealers;
    use backend\models\Shops;
    use backend\models\Boxers;
    $config = Helpers::GetConfig($page, "filtr");
?>

<? if ($config != null) { ?>
    <div class="navbar navbar-default navbar-xs navbar-component" style = "margin-bottom:0;">
        <ul class="nav navbar-nav no-border visible-xs-block">
            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <p class="navbar-text">Фильтр:</p>
            <ul class="nav navbar-nav">
                <?
                $array_filtr = Yii::$app->session->get('filtr');
                if ($array_filtr[$page] == null) {
                    $array_filtr[$page] = array();
                }
                ?>
                <? foreach ($config as $global_key => $param) { ?>
                    <? if ($param['type'] == "static") { ?>
                        <li class="<? if (array_key_exists($global_key, $array_filtr[$page])) { ?>active<? } ?> dropdown">
                            <a href="#" class="filtr-toggle dropdown-toggle" data-toggle="dropdown"><i class="<?=$param['icon']?> position-left"></i> <?=$param['label']?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class = "<? if (!array_key_exists($global_key, $array_filtr[$page])) { ?>active<? } ?> go-filtr" data-page = "<?=$page?>" data-field = "<?=$global_key?>" data-value = "all"><a href="#">Показать все</a></li>
                                <li class="divider"></li>
                                <? foreach($param['data'] as $local_key => $value) { ?>
                                    <? if (array_key_exists($global_key, $array_filtr[$page])) { ?>
                                        <li class = "<? if ($array_filtr[$page][$global_key] == $local_key) { ?>active<? } ?> go-filtr" data-page = "<?=$page?>" data-field = "<?=$global_key?>" data-value = "<?=$local_key?>"><a href="#"><?=$value?></a></li>
                                    <? } else { ?>
                                        <li class = "go-filtr" data-page = "<?=$page?>" data-field = "<?=$global_key?>" data-value = "<?=$local_key?>"><a href="#"><?=$value?></a></li>
                                    <? } ?>
                                <? } ?>
                            </ul>
                        </li>
                    <? } else if ($param['type'] == "date") { ?>
                        <li class="<? if (array_key_exists($global_key, $array_filtr[$page])) { ?>active<? } ?> dropdown">
                            <a href="#" data-field = "<?=$global_key?>" class="daterange-picker filtr-toggle dropdown-toggle"><i class="<?=$param['icon']?> position-left"></i> <?=$param['label']?> <span class="caret"></span></a>
                        </li>
                        <script>
                            $(function() {
                                var token = $('meta[name=csrf-token]').attr("content");
                                $('.daterange-picker').daterangepicker(
                                    {
                                        startDate: <? if ($array_filtr[$page][$global_key]['start'] != null) { echo '"'.date("d/m/y", $array_filtr[$page][$global_key]['start']).'"'; } else { ?>moment().subtract(29, 'days')<? } ?>,
                                        endDate: <? if ($array_filtr[$page][$global_key]['end'] != null) { echo '"'.date("d/m/y", $array_filtr[$page][$global_key]['end']).'"'; } else { ?>moment()<? } ?>,
                                        dateLimit: { days: 120 },
                                        ranges: {
                                            'Сегодня': [moment(), moment()],
                                            'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                            'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                                            'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                                            'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                                            'Прошедший месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                        },
                                        locale: {
                                            format: 'DD/MM/YYYY',
                                            applyLabel: 'Вперед',
                                            cancelLabel: 'Отмена',
                                            startLabel: 'Начальная дата',
                                            endLabel: 'Конечная дата',
                                            customRangeLabel: 'Выбрать дату',
                                            daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
                                            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                                            firstDay: 1
                                        },
                                        opens: 'right',
                                        applyClass: 'btn-small bg-primary',
                                        cancelClass: 'btn-small btn-default'
                                    },
                                    function(start, end) {
                                        $.ajax({
                                            type: "POST",
                                            url: "/profile/tables/filtrdate/",
                                            data:{"_csrf-backend":token, page:"<?=$page?>", field:"<?=$global_key?>", start:start.format('DD.MM.YYYY HH:MM'), end:end.format('DD.MM.YYYY HH:MM')},
                                            success: function() {
                                                $('#<?=$page?>').trigger('click');
                                            },
                                        }).fail(function (xhr) {
                                            console.log(xhr. responseText);
                                        });
                                    },
                                );

                            });
                        </script>
                    <? } else if ($param['type'] == "dynamic") { ?>
                        <li class="filtr-dynamic <? if (array_key_exists($global_key, $array_filtr[$page])) { ?>active<? } ?>">
                            <a data-toggle="modal" data-target="#<?=$global_key?>" href="#"><i class="<?=$param['icon']?> position-left"></i> <?=$param['label']?> <span class="caret"></span></a>
                        </li>
                    <? } ?>
                <? } ?>
            </ul>
        </div>
    </div>

    <? if($array_filtr[$page] != null) { ?>
        <div class="navbar navbar-default navbar-xs navbar-component" style = "margin-bottom:0; margin-top:10px; z-index: 999;">
            <ul class="nav navbar-nav no-border visible-xs-block">
                <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
            </ul>
            <div class="navbar-collapse collapse" id="navbar-filter">
                <p class="navbar-text">Текущая фильтрация:</p>
                <ul class="nav navbar-nav">
                    <? foreach ($array_filtr[$page] as $key => $value) { ?>
                        <? if ($key == "rod_id") { ?>
                            <li class = "del-filtr" data-page = "<?=$page?>" data-field = "<?=$key?>">
                                <a href="#" class="dropdown-toggle"><i class="<?=$config['dealer']['icon']?> position-left"></i> <? echo Dealers::find()->where(['id' => $value])->one()->name?></a>
                            </li>
                        <? } else if ($key == "user_id") { ?>
                            <li class = "del-filtr" data-page = "<?=$page?>" data-field = "<?=$key?>">
                                <a href="#" class="dropdown-toggle"><i class="<?=$config['seller']['icon']?> position-left"></i> <? echo Dealers::find()->where(['id' => $value])->one()->fio?></a>
                            </li>
                        <? } else if ($key == "shop_id") { ?>
                            <li class = "del-filtr" data-page = "<?=$page?>" data-field = "<?=$key?>">
                                <a href="#" class="dropdown-toggle"><i class="<?=$config['shop']['icon']?> position-left"></i> <? echo Shops::find()->where(['shop_id' => $value])->one()->shop_name?></a>
                            </li>
                        <? } else if (count($array_filtr[$page][$key]) == 1) { ?>
                            <li class = "del-filtr" data-page = "<?=$page?>" data-field = "<?=$key?>">
                                <a href="#" class="dropdown-toggle"><i class="<?=$config[$key]['icon']?> position-left"></i> <?=$config[$key]['data'][$value]?></a>
                            </li>
                        <? } else { ?>
                            <li class = "del-filtr" data-page = "<?=$page?>" data-field = "<?=$key?>">
                                <? if ($array_filtr[$page][$key]['start'] != $array_filtr[$page][$key]['end']) { ?>
                                    <a href="#" class="dropdown-toggle"><i class="<?=$config[$key]['icon']?> position-left"></i> <?=date("d/m/Y", $array_filtr[$page][$key]['start'])?> - <?=date("d/m/Y", $array_filtr[$page][$key]['end'])?></a>
                                <? } else { ?>
                                    <a href="#" class="dropdown-toggle"><i class="<?=$config[$key]['icon']?> position-left"></i> <?=date("d/m/Y", $array_filtr[$page][$key]['start'])?></a>
                                <? } ?>
                            </li>
                        <? } ?>
                    <? } ?>
                </ul>
            </div>
        </div>
    <? } ?>
<? } ?>
<? foreach ($config as $global_key => $param) { ?>
    <? if ($param['type'] == "dynamic") { ?>
        <div id="<?=$global_key?>" class="modal fade" data-backdrop="false" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><?=$param['label']?></h5>
                    </div>

                    <div class="modal-body">
                        <select id = "select_<?=$global_key?>" name = "<?=$global_key?>" class="select" required ="required">
                            <option <? if ($array_filtr[$page] == null) { ?>selected<? } ?> value="0">Все</option>
                            <? foreach ($param['data'] as $key => $value) { ?>
                                <option <? if ($array_filtr[$page][$global_key] == $key) { ?>selected<? } ?> value="<?=$key?>"><?=$value?></option>
                            <? } ?>
                        </select>
                        <script>
                            $("#select_<?=$global_key?>").select2();
                        </script>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                        <button data-page = "<?=$page?>" data-field = "<?=$global_key?>" type="button" class="filtr-dynamic btn btn-primary">Применить</button>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>


