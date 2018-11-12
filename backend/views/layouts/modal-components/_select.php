<div class="form-group">
    <label class = "text-semibold"><?=$info[0]?>:</label>
    <select name = "Information[<?=$info[1]?>]" class="select">
        <? foreach ($info[2] as $key => $value) { ?>
            <option <? if ($key == $info[3]) { ?>selected<? } ?> value="<?=$key?>"><?=$value?></option>
        <? } ?>
    </select>
</div>