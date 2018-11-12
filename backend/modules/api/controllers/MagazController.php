<?php
namespace backend\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class MagazController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionLoad() {
        $this->enableCsrfValidation = false;
        $key = $_POST['key'];
        echo "key: ".$key;
    }

}
?>
