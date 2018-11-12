<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'files/css/fonts.css',
        'files/css/icons/icomoon/styles.css',
        'files/css/icons/fontawesome/styles.min.css',
        'files/css/bootstrap.css',
        'files/css/core.css',
        'files/css/components.css',
        'files/css/colors.css',
        'files/css/customize.css',
    ];
    public $js = [
        'files/js/plugins/loaders/pace.min.js',
        'files/js/core/libraries/jquery.min.js',
        'files/js/core/libraries/bootstrap.min.js',
        'files/js/plugins/loaders/blockui.min.js',
        'files/js/plugins/notifications/bootbox.min.js',

        'files/js/plugins/forms/validation/validate.min.js',
        'files/js/plugins/forms/validation/localization/messages_ru.js',
        'files/js/plugins/forms/selects/bootstrap_multiselect.js',
        'files/js/plugins/forms/inputs/touchspin.min.js',
        'files/js/plugins/forms/selects/select2.min.js',
        'files/js/plugins/forms/styling/switch.min.js',
        'files/js/plugins/forms/styling/switchery.min.js',
        'files/js/plugins/forms/styling/uniform.min.js',
        'files/js/plugins/ui/moment/moment.min.js',
        'files/js/plugins/pickers/daterangepicker.js',
        'files/js/core/app.js',
        'files/js/plugins/ui/ripple.min.js',
        'files/js/pages/extension_blockui.js',
        'files/js/cronos/main.js',
        'files/js/cronos/forms.js',
        'files/js/plugins/tables/datatables/datatables.min.js',
        'files/js/plugins/tables/datatables/extensions/responsive.min.js',
        'files/js/core/libraries/jasny_bootstrap.min.js'
    ];

    public $depends = [];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}