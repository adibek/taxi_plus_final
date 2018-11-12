<script type="text/javascript" src="/profile/files/js/pages/ckeditor1/ckeditor.js"></script>

<script>
    $(function() {

        // Full featured editor
        var editor = CKEDITOR.replace( 'editor-medium', {
            height: '400px',
            extraPlugins: 'forms'
        });

        editor.on( 'change', function( evt ) {
            $("#editor-medium").val(evt.editor.getData());
        });

    });

</script>

<div class="form-group" >
    <label class = "text-semibold"><?=$info[0]?>:</label>
    <textarea name = "Information[<?=$info[1]?>]" id="editor-medium" rows="4" cols="4"><?=$info[2]?></textarea>
</div>