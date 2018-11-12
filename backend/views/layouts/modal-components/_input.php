<div class="form-group">
    <label class = "text-semibold"><?=$info[0]?>:</label>
    <input type = "<?=$info[2]?>" name = "Information[<?=$info[1]?>]" class="form-control" value = "<?=$info[3]?>" <? if ($info[4] == true) { ?>required = "required"<? } ?> placeholder="<? if($info[5] != null){?><?=$info[5]?><?;}else{?><?=$info[0]?><?}?>">
</div>