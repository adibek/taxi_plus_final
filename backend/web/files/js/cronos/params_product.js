$(function () {
    var palette = [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ];


    var count = 0;
    var addColorHtml = "<div class = 'rod-color mb-10 mr-10' style = 'display:inline-block;'><input id = 'id_"+ count +"' type='text' name = 'colors[]' class='form-control colorpicker-palette-only' value='#27ADCA'>" +
        '<a href = "#" data-id = "'+ count +'" class = "delete_color text-bold ml-5 mr-5">X</a></div>';


    $('body').off('click', '#add-parameter-button');
    $('body').on('click', '#add-parameter-button', function(e) {
        e.preventDefault();
        var token = $('meta[name=csrf-token]').attr("content");
        var key = getRandomInt(1000, 9999);
        $.ajax({
            type: "POST",
            url: "/profile/params/getparams/",
            data:{"_csrf-backend":token},
            success: function(data) {
                console.log(data);
                var customParameterHtml = "<!-- Parameter -->" +
                    "                <div class='col-md-12 mb-10' style = 'padding:10px;border:1px solid #bbbbbb;'>" +
                    "                   <div class='form-group'>" +
                    "                       <div class='col-lg-2' style = 'padding:0;'>" +
                    "                           <label class = 'text-semibold'>Название параметра:</label>" +
                    "                           <select name = 'parameter[" + key + "][]' class='select'>"
                                                    + data +
                    "                           </select>" +
                    "                       </div>" +
                    "                       <div class='col-lg-6'>" +
                    "                           <label>Действия:</label><br/>" +
                    "                           <button data-key = '" + key + "' id='add-par-button' class='btn btn-success' type='button'>Добавить параметр</button>" +
                    "                           <button id='remove-parameter-button' class='btn btn-danger' type='button'>Удалить характеристику</button>" +
                    "                       </div>" +
                    "                   </div>" +
                    "                </div>";

                $('#parameter-insert-helper').append(customParameterHtml);
                $('.select').select2();
            },
        }).fail(function (xhr) {
            console.log(xhr. responseText);
        });



    });

    /* color buttons */
    $('body').off('click', '#add-color-button');
    $('body').on('click', '#add-color-button', function(e) {
        e.preventDefault();

        $('#color-insert-helper').before(addColorHtml);
        $(".colorpicker-palette-only").spectrum({
            showPalette: true,
            showPaletteOnly: true,
            preferredFormat: "hex",
            palette: palette
        });
    });
    /* size parameter button */
    $('body').off('click', '#remove-parameter-button');
    $('body').on('click', '#remove-parameter-button', function(e) {
        e.preventDefault();
        $(this).closest('.col-md-12').remove();
    });

    $('body').off('click', '#add-par-button');
    $('body').on('click', '#add-par-button', function(e) {
        e.preventDefault();
        var key = $(this).data("key");
        $(this).parent().parent().append('<div class="col-md-12 mt-10" style = "padding:0;"><div class="col-lg-2" style = "padding:0;"><label class = "text-semibold">Параметр:</label><input type="text" name="parameter[' + key + '][]" class="form-control" placeholder="Значение параметра"></div><div class="col-lg-1"><label>Действия:</label><br/><button id="remove-parameter-button" class="btn btn-danger" type="button">Удалить</button></div></div>');
    });

    function getRandomInt(min, max)
    {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

});
