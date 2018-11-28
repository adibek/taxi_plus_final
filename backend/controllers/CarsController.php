<?php
namespace backend\controllers;
use backend\components\Helpers;
use backend\models\CarModels;
use backend\models\Cities;
use backend\models\Region;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class CarsController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = CarModels::find()->where(['id' => $id])->one();
            } else {
                $model = new CarModels();
            }
            $model->attributes = $_POST['Information'];
            $model->parent_id = -1;

            if($model->save()){
                $response['message'] = "Марка успешно добавлен";
                $response['type'] = "success";
            }else{
                $response['message'] = "Произошла ошибка, попробуйте позже";
                $response['type'] = "error";
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }

    public function actionSubmodel(){
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = CarModels::find()->where(['id' => $id])->one();
            } else {
                $model = new CarModels();
            }
            $model->parent_id = Yii::$app->session->get('last_car');
            $model->attributes = $_POST['Information'];
            if($model->save()){
                $response['message'] = "Модель успешно добавлен";
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