<?php
namespace backend\controllers;
use backend\components\Helpers;
use backend\models\Cities;
use backend\models\Region;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class RegionsController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = Region::find()->where(['id' => $id])->one();
            } else {
                $model = new Region();
            }
            $model->attributes = $_POST['Information'];

            if($model->save()){
                $response['message'] = "Регион успешно добавлен";
                $response['type'] = "success";
            }else{
                $response['message'] = "Произошла ошибка, попробуйте позже";
                $response['type'] = "error";
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }

    public function actionCity(){
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = Cities::find()->where(['id' => $id])->one();
            } else {
                $model = new Cities();
            }
            $model->region_id = Yii::$app->session->get('last_region');
            $model->attributes = $_POST['Information'];
            if($model->save()){
                $response['message'] = "Населенный пункт успешно добавлен";
                $response['type'] = "success";
            }else{
                $response['message'] = "Произошла ошибка, попробуйте позже";
                $response['type'] = "error";
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }
}

?>