<?php
namespace backend\controllers;
use backend\models\SystemUsers;
use DateTime;
use Yii;
use yii\web\Controller;
use backend\models\Users;
use backend\models\Messages;
use backend\models\Orders;
use backend\models\TaxiPark;
use backend\models\RadialPricing;
use backend\models\SavedAddresses;
use yii\db\query;
use backend\models\PossibleDrivers;
use yii\web\Response;
use yii\web\User;
use backend\models\Services;
use backend\models\TaxiParkServices;
use backend\models\MonetsTraffic;


class TaxiParkController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if ($id != null) {
                $model = TaxiPark::find()->where(['id' => $id])->one();
            } else {
                $model = new TaxiPark();
            }
            $model->attributes = $_POST['Information'];
            $model->city_id = $_POST['city_id'];
            $model->type = $_POST['payment'];
            $model->save();
            if ($model->save()) {

                if($id != null){
                    $response['message'] = "Таксопарк изменен";
                }else{
                    $response['message'] = "Таксопарк успешно добавлен";
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


    public function actionAdmin()
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
            }

            $model->attributes = $_POST['Information'];
            $model->taxi_park_id = $_POST['tpark'];
            $model->created = strtotime("now");
            $model->password = md5($_POST['Information']['password']);
            $model->role_id = 5;

            if ($model->save()) {

                if($id != null){
                    $response['message'] = "Администратор изменен";
                }else{
                    $response['message'] = "Администратор успешно добавлен";
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

    public function actionCashier(){
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            $balance = $_POST['Information']['balance'];
            $tp = TaxiPark::find()->where(['id' => $id])->one();
            $old_val = $tp->balance;
            if($tp == null){
                $response['type'] = 'error';
                $response['message'] = "Неизвестная ошибка, попробуйте позже.";
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            }
            $log = new MonetsTraffic();
            $log->amount = $balance - $old_val;
            $log->reciever_tp_id = $tp->id;
            $log->reciever_user_id = 111;
            $log->sender_user_id = Yii::$app->session->get("profile_id");
            $log->sender_tp_id = Yii::$app->session->get("profile_tp");

            $now = new DateTime();
            $log->date = $now->getTimestamp();
            $log->save();

            $tp->balance = $balance;
            $tp->save();
            $response['type'] = 'success';
            $response['message'] = "Баланс успешно пополнен.";
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }
    }

}

?>