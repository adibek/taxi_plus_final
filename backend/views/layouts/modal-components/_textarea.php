<div class="form-group">
    <label class = "text-semibold"><?=$info[0]?>:</label>
    <textarea rows="5" cols="5" class="form-control" <? if ($info[3] == true) { ?>required = "required"<? } ?> name = "Information[<?=$info[1]?>]" placeholder="<?=$info[0]?>"><?=$info[2]?></textarea>
</div>