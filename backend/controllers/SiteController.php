<?php
namespace backend\controllers;

use backend\components\SendMail;
use backend\components\Stats;

use backend\models\MonetsTraffic;
use backend\models\Users;
use PHPExcel_Settings;
use Yii;
use backend\models\SystemUsersCities;

use backend\models\SystemUsers;
use backend\models\Services;
use backend\models\TaxiParkPrivileges;
use backend\models\TaxiPark;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use backend\components\Helpers;


class SiteController extends Controller
{

    public function behaviors()
    {
        return [];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAuthentication() {
        Helpers::CheckAuth("redirect", "/profile/");
        return $this->render('index');
    }


    public function actionLogin() {
        if (Yii::$app->request->isAjax) {


            $profile = SystemUsers::findOne(['email' => $_POST['email']]);

           if($profile != null){
               $request['message'] = "Вы успешно авторизовались";
               $request['type'] = "success";

               $cities = SystemUsersCities::find()->where(['system_user_id' => $profile->id])->all();
               $id = [];
               foreach ($cities as $k => $v){
                   array_push($id, $v->id);
               }
               Yii::$app->session->set('profile_auth', 'OK');
               Yii::$app->session->set('profile_id', $profile->id);
               Yii::$app->session->set('profile_tp', $profile->taxi_park_id);
               Yii::$app->session->set('profile_ip', $_SERVER['REMOTE_ADDR']);
               Yii::$app->session->set('company_id', $profile->company_id);
               Yii::$app->session->set('profile_fio', $profile->first_name . ' ' . $profile->last_name);
               Yii::$app->session->set('profile_role', $profile->role_id);
               Yii::$app->session->set('profile_cities', $id);
           }else{
               $request['message'] = "User not found";
               $request['type'] = "error";
           }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $request;
        }
    }

    public function actionLogout()
    {
        Yii::$app->session->set('profile_auth', 'NONE');
        Yii::$app->session->set('profile_id', 0);
        Yii::$app->session->set('profile_ip', null);
        Yii::$app->session->set('profile_role', null);
        Yii::$app->session->set('navigation_back',  null);
        Yii::$app->session->set('filtr',  null);
        Yii::$app->session->set('filtrTables',  null);
        return $this->goHome();
    }

    public function actionDelete() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $table = $_POST['table'];
            if ($id != null) {
                Yii::$app->db->createCommand()->delete($table, ['id' => $id])->execute();
                $request['message'] = "Удаление прошло успешно";
                $request['type'] = "success";
            } else {
                $request['message'] = "Неизвестная ошибка, попробуйте позже";
                $request['type'] = "error";
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $request;
        }
    }


    public function actionBalance() {
        if (Yii::$app->request->isAjax) {

            $me = \backend\models\Users::find()->where(['id' => Yii::$app->session->get("profile_id")])->one();
            $taxi_park = \backend\models\TaxiPark::find()->where(['id' => $me->taxi_park_id])->one();

            $request['balance'] = $taxi_park->balance;

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $request;
        }
    }
    public function actionDrivers(){
        $drivers_count = count(\backend\models\Users::find()->where(['role_id' => 2])->andWhere(['is_active' => 0])->all());
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request['count'] = $drivers_count;

        return $request;
    }

    public function actionChangePrice() {
        if (Yii::$app->request->isAjax) {

            $prices = $_POST['price'];
            $referal = $_POST['referal'];
            

            foreach ($prices as $key => $value){
                $service = Services::find()->where(['id' => $key+1])->one();
                $service->access_price = $value;
                $service->save();
            }
            foreach ($referal as $key => $value){
                $service = Services::find()->where(['id' => $key+1])->one();
                $service->referal_price = $value;
                $service->save();
            }

            $request['type'] = 'success';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $request;
        }
    }
    public function actionBuyAccess() {
        if (Yii::$app->request->isAjax) {


            $me = Users::find()->where(['id' => Yii::$app->session->get("profile_id")])->one();
            $tp = TaxiPark::find()->where(['id' => $me->taxi_park_id])->one();

            $total_sum = 0;
            foreach ($_POST['amount'] as $k => $v){
                $price = Services::find()->where(['id' => $k])->one();
                $total_sum += $price->access_price * $v;
            }

            if($tp->balance < $total_sum){
                $request['type'] = 'error';
            }else{
                foreach ($_POST['amount'] as $k => $v){
                    if($v != null){
                        $model = TaxiParkPrivileges::find()->where(['taxi_park_id' => $me->taxi_park_id])->andWhere(['service_id' => $k])->one();
                        if($model == null){
                            $model = new TaxiParkPrivileges();
                            $model->taxi_park_id = $me->taxi_park_id;
                            $model->service_id = $k;
                            $model->amount = $v;
                        }else{
                            $model->amount = $v + $model->amount;
                        }
                        $model->save();

                    }
                }

                $tp->balance = $tp->balance - $total_sum;
                $tp->save();

                $request['type'] = 'success';
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $request;
        }
    }

    public function actionAddBalance(){
        $id = $_GET['id'];
        $monets = $_GET['monets'];

        $tp = TaxiPark::find()->where(['id' => $id])->one();
        $tp->balance += $monets;
        if($tp->save()){
            $response["type"] = 'success';
        }else{
            $response["type"] = 'error';
        }

        $log = new MonetsTraffic();
        $log->sender_user_id = Yii::$app->session->get('profile_id');
        $log->sender_tp_id = 0;
        $log->reciever_user_id = 111;
        $log->reciever_tp_id = $id;
        $log->amount = $monets;
        $log->date = strtotime('now');
        $log->save();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }

    public function actionDriverBalance(){
        $id = $_GET['id'];
        $amount = $_GET['amount'];
        $driver = Users::findOne(['id' => $id]);
        $driver->balance += $amount;
        if($driver->save()){
            $response["type"] = 'success';
        }else{
            $response["type"] = 'error';
        }
        $log = new MonetsTraffic();
        $log->sender_user_id = Yii::$app->session->get('profile_id');
        $log->sender_tp_id = Helpers::getMyTaxipark();
        $log->amount = $amount;
        $log->reciever_user_id = $id;
        $log->reciever_tp_id = $driver->taxi_park_id;
        $log->date = strtotime('now');
        $log->type_id = 1;
        $log->save();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }


}
