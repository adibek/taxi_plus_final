<div class="heading-elements">
    <div class="heading-btn-group">
        <? if ($page == "admins/moderators") { ?>
            <a data-id = "0" href="moderators/form-moderator" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить модератора<span class="legitRipple-ripple"></span></a>
        <? }
        else if ($page == "admins") { ?>
            <a data-id = "0" href="admins/form-admin" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить администратора<span class="legitRipple-ripple"></span></a>
        <? } else if ($page == "tadmins") {?>
            <a data-id = "0" href="tadmins/form-tadmin" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить администратора<span class="legitRipple-ripple"></span></a>
        <? } else if ($page == "taxi-parks") {?>
                <a data-id = "-1" href="taxi-parks/form-taxi-park" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить таксопарк<span class="legitRipple-ripple"></span></a>

        <? } else if ($page == "drivers") {?>
        <a data-id = "0" href="drivers/form-driver" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить водителя<span class="legitRipple-ripple"></span></a>
        <? } else if ($page == "cashiers") {?>
        <a data-id = "0" href="cashiers/form-cashier" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить кассира<span class="legitRipple-ripple"></span></a>
        <? }  else if($page == "companies"){?>
        <a data-id = "0" href="companies/form-company" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить компанию<span class="legitRipple-ripple"></span></a>
        <? } else if($page == "cadmins"){?>
            <a data-id = "0" href="cadmins/form-admin" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить администратора<span class="legitRipple-ripple"></span></a>
        <? } else if($page == "coworkers"){?>
            <a data-id = "0" href="coworkers/add_user.php" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить сотрудника<span class="legitRipple-ripple"></span></a>
        <? } else if($page == "dispatchers"){?>
            <a data-id = "0" href="dispatchers/form-dispatcher" class="action-link btn bg-success btn-labeled heading-btn legitRipple"><b><i class="icon-plus2"></i></b> Добавить диспетчера<span class="legitRipple-ripple"></span></a>
        <? } ?>
    </div>
</div>
