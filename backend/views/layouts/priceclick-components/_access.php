<?php
    $load_access = explode(":", Yii::$app->session->get('profile_access'));

    $ex_access = explode(":", $access);
    $array = array(
        "admins" => array(
            "banner" => "Рекламный баннер",
            "discount" => "Акции и скидки",
            "rating_products" => "Регулировать рейтинг товара",
            "rating_shops" => "Регулировать рейтинг магазина",
            "top_shops" => "Поднять магазин на верхнюю строчку",
            "icon_top_shops" => "Значок топ",
            "icon_delivery_shops" => "Значок быстрая доставка",
            "view_data" => "Видеть номер телефона и E-Mail адрес",
            "monetization" => "Регулировать процент монетизации для магазинов",
        ),
        "dealers" => array(
            "banner" => "Рекламный баннер",
            "discount" => "Акции и скидки",
            "rating_products" => "Регулировать рейтинг товара",
            "rating_shops" => "Регулировать рейтинг магазина",
            "top_shops" => "Поднять магазин на верхнюю строчку",
            "icon_top_shops" => "Значок топ",
            "icon_delivery_shops" => "Значок быстрая доставка",
            "view_data" => "Видеть номер телефона и E-Mail адрес",
            "monetization" => "Регулировать процент монетизации для магазинов",
        ),
        "sellers" => array(
            "banner" => "Рекламный баннер",
            "discount" => "Акции и скидки",
            "rating_products" => "Регулировать рейтинг товара",
            "rating_shops" => "Регулировать рейтинг магазина",
            "top_shops" => "Поднять магазин на верхнюю строчку",
            "icon_top_shops" => "Значок топ",
            "icon_delivery_shops" => "Значок быстрая доставка",
            "view_data" => "Видеть номер телефона и E-Mail адрес",
        ),
    );
?>

<div class = "col-md-12">
    <label class = "text-semibold">Права доступа</label>
    <div class="form-group">
        <? foreach ($array[$name] as $key => $value) { ?>
            <? if (in_array($key, $load_access) OR Yii::$app->session->get('profile_role') == "superadmin") { ?>
                <div class="checkbox">
                    <label>
                        <input name = "Access[<?=$key?>]" type="checkbox" class="styled" <? if (in_array($key, $ex_access)) { ?>checked="checked"<? } ?>>
                        <?=$value?>
                    </label>
                </div>
            <? } ?>
        <? } ?>
    </div>
</div>