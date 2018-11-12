<script type="text/javascript" src="/profile/files/js/plugins/ui/dragula.min.js"></script>
<script type="text/javascript" src="/profile/files/js/cronos/cascade.js"></script>

<p class = "text-muted">Нажите на элемент для его открытия.<br/>Вы также можете менять порядок элементов, для этого перетащите элемент.</p>
<ul class="media-list media-list-container" id="media-list-target-left"></ul>
<script>
    var token = $('meta[name=csrf-token]').attr("content");
    var json = <?php echo json_encode($data); ?>;
    function GetCascade() {
        console.log(json);
        $.ajax({
            type: "POST",
            url: "/profile/cascade/getcascade/",
            data: {"_csrf-backend":token, page:"<?=$page?>"},
            status: $("#media-list-target-left").html('<div class="progress"><div class="progress-bar progress-bar-striped active" style="width: 100%"> </div> </div>\n'),
            success: function (data) {
                $("#media-list-target-left").html(data);
            },
        }).fail(function (xhr) {
            console.log(xhr.responseText);
        });
    }
    GetCascade();
</script>