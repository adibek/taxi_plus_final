<?php
namespace backend\controllers;
use backend\components\Helpers;
use backend\models\SystemUsers;
use backend\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use backend\models\Company;

class CompanyController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = Company::find()->where(['id' => $id])->one();
            } else {
                $model = new Company();
            }
            $model->attributes = $_POST['Information'];
            $model->city_id = $_POST['city_id'];
            if($model->save()){
                $response['message'] = "Компания успешно добавлена";
                $response['type'] = "success";
            }else{
                $response['message'] = "Произошла ошибка, попробуйте позже";
                $response['type'] = "error";
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }
    public function actionAddUser(){
        $id = $_POST["id"];
        $user = Users::find()->where(['id' => $id])->one();
        $user->company_id = Helpers::getMyCompany();
        $response['id'] = $id;
        if($user->save()){
            $response['type'] = "success";
        }else{
            $response['type'] = "error";
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }



    public function actionCadmins()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if ($id != null) {
                $model = SystemUsers::find()->where(['id' => $id])->one();
            } else {
                $user = SystemUsers::find()->where(['email' => $_POST['Information']['email']])->one();
                if ($user != null) {
                    $response['message'] = "Пользователь с таким email уже зарегистрирован.";
                    $response['type'] = "error";
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $response;
                }
                $model = new SystemUsers();
                $model->created = strtotime("now");
                $model->password = md5($_POST['Information']['password']);

            }
            $model->company_id = $_POST['company'];
            $model->attributes = $_POST['Information'];
            $model->role_id = 7;
            $model->taxi_park_id = 0;

            if ($model->save()) {
                if($id != null){
                    $response['message'] = "Администратор КК изменен";
                }else{
                    $response['message'] = "Администратор КК успешно добавлен";
                }

                $response['type'] = "success";

            } else {
                $response['message'] = "Неизвестная ошибка, попробуйте позже.";
                $response['type'] = "error";
            }


            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }



    }

    public function actionSearch(){
        $phone = $_POST['phone'];
        $result = Users::find()->where(['phone' => $phone])->andWhere(['company_id' => NULL])->all();
        $response['users'] = $result;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }

}

?>