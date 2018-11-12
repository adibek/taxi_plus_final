<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use backend\models\Services;
use backend\models\TaxiParkServices;

class ServicesController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $res = Services::find()->all();
            $rand = rand();
            $response['data'] = $res;
            $response['rand'] = $rand;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }


}

?>