
<!--<script type="text/javascript" src="/profile/files/js/mytables/stats/drivers.js"></script>-->

<?=$this->render("/layouts/header/_header", array('info' => $info))?>

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
                            <th>Название</th>
                            <th>Регион</th>
                            <? if($model->type < 15){
                                ?>
                                <th>Полученные монеты через оплату</th>
                                <th>Выданные монеты водителям</th>
                                <?
                            }else{
                                ?>
                                <th colspan="3">Полученные монеты</th>
                                <th colspan="2">Выданные монеты</th>
                                <?
                            }?>
                        </tr>
                        <?
                        if($model->type > 14){
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Через оплату</td>
                                <td>Бонусные</td>
                                <td>Корп. клиентов</td>
                                <td>Бонусные</td>
                                <td>Taxi Plus</td>
                            </tr>

                            <?
                        }
                        ?>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // if wotking type == 1
    <? if($model->type < 15){
                ?>
    $(function() {
        var token = $('meta[name=csrf-token]').attr("content");
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                "emptyTable":       "Данные отсутствуют.",
                "info":             "Показано с _START_ по _END_, всего: _TOTAL_",
                "infoEmpty":        "Показано 0 из 0, всего 0",
                "infoFiltered":     "(отфильтровано из _MAX_)",
                "infoPostFix":      "",
                "lengthMenu":       "<span>Показано:</span> _MENU_",
                "loadingRecords":   "Загрузка...",
                "processing":       "Загрузка...",
                "search":           "<span>Поиск:</span> _INPUT_",
                "searchPlaceholder": 'Введите ключевые слова...',
                "zeroRecords":      "Данные отсутствуют.",
                "paginate": {
                    "first":        "Первая",
                    "previous":     "&larr;",
                    "next":         "&rarr;",
                    "last":         "Последняя"
                },
                "aria": {
                    "sortAscending":    ": activate to sort column ascending",
                    "sortDescending":   ": activate to sort column descending"
                },
                "decimal":          "",
                "thousands":        ","
            },


            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });
        $('.table').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax":{
                url :"/profile/tables/get-new-table/",
                type: "GET",
                data: {"_csrf-backend":token, table:"taxi_park", name:"stat-tp", id: <?=$model->id?>}
            },
            "stateSave": true,
            "stateSaveCallback": function (settings, data) { //Сохраняем таблицу (Страница, Сортировка, Количество записей и т.д)
                $.ajax({
                    url: "/profile/tables/savestate/",
                    dataType: "json",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        console.log('save>>>', response);
                    }
                });
            },
            "stateLoadCallback": function (settings, callback) { //Загружаем сохраненные настройки таблицы
                $.ajax( {
                    url: '/profile/tables/getstate/',
                    async: false,
                    dataType: 'json',
                    success: function (json) {
                        console.log('load>>>', json);
                        callback(json);
                    }
                } );
            },
            aoColumns: [
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.id + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.name + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.city + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.income_1 + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.outcome_1 + '</label>';
                    }
                },
            ],
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
        function timeConverter(UNIX_timestamp){
            var a = new Date(UNIX_timestamp * 1000);
            var months = ['Янв','Фев','Мар','Aпр','Maй','Июн','Июл','Авс','Сен','Окт','Ноя','Дек'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var date = a.getDate();
            var hour = a.getHours();
            var min = a.getMinutes();

            var sec = a.getSeconds();
            var minutes = '';
            if(min < 10){
                minutes = '0' + min;
            }else{
                minutes = min;
            }
            var hrs = '';
            if(hour < 10){
                hrs = '0' + hour;
            }else{
                hrs = hour;
            }
            var time = date + ' ' + month + ' ' + year + ', ' + hrs + ':' + minutes;
            return time;
        }
    });

    <?
    }else{
        ?>

    $(function() {
        var token = $('meta[name=csrf-token]').attr("content");
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                "emptyTable":       "Данные отсутствуют.",
                "info":             "Показано с _START_ по _END_, всего: _TOTAL_",
                "infoEmpty":        "Показано 0 из 0, всего 0",
                "infoFiltered":     "(отфильтровано из _MAX_)",
                "infoPostFix":      "",
                "lengthMenu":       "<span>Показано:</span> _MENU_",
                "loadingRecords":   "Загрузка...",
                "processing":       "Загрузка...",
                "search":           "<span>Поиск:</span> _INPUT_",
                "searchPlaceholder": 'Введите ключевые слова...',
                "zeroRecords":      "Данные отсутствуют.",
                "paginate": {
                    "first":        "Первая",
                    "previous":     "&larr;",
                    "next":         "&rarr;",
                    "last":         "Последняя"
                },
                "aria": {
                    "sortAscending":    ": activate to sort column ascending",
                    "sortDescending":   ": activate to sort column descending"
                },
                "decimal":          "",
                "thousands":        ","
            },


            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });
        $('.table').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax":{
                url :"/profile/tables/get-new-table/",
                type: "GET",
                data: {"_csrf-backend":token, table:"taxi_park", name:"stat-tp", id: <?=$model->id?>}
            },
            "stateSave": true,
            "stateSaveCallback": function (settings, data) { //Сохраняем таблицу (Страница, Сортировка, Количество записей и т.д)
                $.ajax({
                    url: "/profile/tables/savestate/",
                    dataType: "json",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        console.log('save>>>', response);
                    }
                });
            },
            "stateLoadCallback": function (settings, callback) { //Загружаем сохраненные настройки таблицы
                $.ajax( {
                    url: '/profile/tables/getstate/',
                    async: false,
                    dataType: 'json',
                    success: function (json) {
                        console.log('load>>>', json);
                        callback(json);
                    }
                } );
            },
            aoColumns: [
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.id + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.name + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.city + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.income_pay + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.income_bonus + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.income_kk + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.outcome_tp + '</label>';
                    }
                },
                {"mData": {},
                    "mRender": function (data, type, row) {

                        return '<label class="text-semibold">'+ data.outcome_bonus + '</label>';
                    }
                },

            ],
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
        function timeConverter(UNIX_timestamp){
            var a = new Date(UNIX_timestamp * 1000);
            var months = ['Янв','Фев','Мар','Aпр','Maй','Июн','Июл','Авс','Сен','Окт','Ноя','Дек'];
            var year = a.getFullYear();
            var month = months[a.getMonth()];
            var date = a.getDate();
            var hour = a.getHours();
            var min = a.getMinutes();

            var sec = a.getSeconds();
            var minutes = '';
            if(min < 10){
                minutes = '0' + min;
            }else{
                minutes = min;
            }
            var hrs = '';
            if(hour < 10){
                hrs = '0' + hour;
            }else{
                hrs = hour;
            }
            var time = date + ' ' + month + ' ' + year + ', ' + hrs + ':' + minutes;
            return time;
        }
    });



    <?
    }?>


</script>