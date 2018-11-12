<script type="text/javascript" src="/profile/files/js/pages/ckeditor/ckeditor.js"></script>

<script>
    $(function() {

        // Full featured editor
        var editor = CKEDITOR.replace( 'editor-full', {
            height: '400px',
            extraPlugins: 'forms'
        });

        editor.on( 'change', function( evt ) {
            $("#editor-full").val(evt.editor.getData());
        });

    });

</script>

<div class="form-group" >
    <label class = "text-semibold"><?=$info[0]?>:</label>
    <textarea name = "Information[<?=$info[1]?>]" id="editor-full" rows="4" cols="4"><?=$info[2]?></textarea>
</div>