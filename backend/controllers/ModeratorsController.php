<?php
namespace backend\controllers;
use backend\models\CarModels;
use backend\models\SystemUsers;
use backend\models\SystemUsersCities;
use backend\models\TaxiPark;
use Facebook\WebDriver\Remote\Service\DriverService;
use Yii;
use DateTime;
use yii\base\Model;
use yii\db\query;
use yii\web\Controller;
use backend\models\Users;
use backend\models\DriversServices;
use backend\models\Orders;
use backend\models\SavedAddresses;
use backend\models\MonetsTraffic;
use backend\models\UsersPrivileges;
use backend\models\TaxiParkPrivileges;
use backend\models\DriversFacilities;
use yii\web\Response;
use yii\web\User;

class ModeratorsController extends Controller
{
    public function actionIndex()
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
            $model->created = strtotime("now");
            $model->password = md5($_POST['Information']['password']);
            $model->role_id = 4;
            $model->taxi_park_id = $_POST['taxi_park'];
            $tp = TaxiPark::findOne($_POST['taxi_park']);


            if ($model->save()) {
                $system_users_city = new SystemUsersCities();
                $system_users_city->system_user_id = $model->id;
                $system_users_city->city_id = $tp->city_id;
                $system_users_city->created = strtotime('now');
                $system_users_city->save();
                if($id != null){
                    $response['message'] = "Модератор изменен";
                }else{
                    $response['message'] = "Модератор успешно добавлен";
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


    public function actionAdmins()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if ($id != null) {
                $model = Users::find()->where(['id' => $id])->one();
            } else {
                $user = Users::find()->where(['email' => $_POST['Information']['email']])->one();
                if ($user != null) {
                    $response['message'] = "Пользователь с таким email уже зарегистрирован.";
                    $response['type'] = "error";
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $response;
                }
                $model = new Users();
                $today = getdate();
                $model->created = strtotime("now");
                $model->password = md5($_POST['Information']['password']);

            }

            $model->attributes = $_POST['Information'];
            $model->last_edit = date("d/m/Y H:i:s", time());
            $model->role_id = 3;

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





    public function actionDriver()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $facs = explode(",", $_POST['facilities']);
            $servcs = explode(",", $_POST['services']);
            if($servcs == null){
                $response['message'] = "Внимание выберите тип водителя!";
                $response['type'] = "error";
                return $response;
            }

            $id = $_POST['id'];
            if($id != null){
                $model = Users::find()->where(['id' => $id])->one();

            }else{

                $model = new Users();

                $model->created = strtotime("now");
                $model->password = md5($_POST['Information']['password']);
                $model->role_id = 2;
            }
            $me = \backend\models\Users::find()->where(['id' => Yii::$app->session->get("profile_id")])->one();
            $taxi_park = \backend\models\TaxiPark::find()->where(['id' => $me->taxi_park_id])->one();
            if($model->balance == $_POST['Information']['balance']){

            }else{

                if($model->balance > $_POST['Information']['balance']){
                    $response['message'] = "Внимание Вы не можете отнять монеты водителя";
                    $response['type'] = "error";
                    return $response;
                }else{
                    if($taxi_park->balance < ($taxi_park->balance - ($_POST['Information']['balance'] - $model->balance))){
                        $response['message'] = "Внимание у Вас недостаточно средств для пополнения баланса водителя";
                        $response['type'] = "error";
                        return $response;
                    }else{

                        $log = new MonetsTraffic();
                        $log->amount = $_POST['Information']['balance'] - $model->balance;
                        $log->reciever_user_id = $model->id;
                        $log->reciever_tp_id = $model->taxi_park_id;
                        $log->sender_user_id = Yii::$app->session->get("profile_id");
                        $log->sender_tp_id = Yii::$app->session->get("profile_tp");
                        $now = new DateTime();
                        $log->date = $now->getTimestamp();
                        $log->save();

                        $taxi_park->balance = $taxi_park->balance - ($_POST['Information']['balance'] - $model->balance);

                        $taxi_park->save();
                    }
                }

            }



            $model->attributes = $_POST['Information'];
            $model->last_edit = date("d/m/Y H:i:s", time());
            $model->taxi_park_id = $_POST['taxi_park_id'];
            $model->car = $_POST['car_id'];
            $model->service_id= $_POST['service_id'];
            $model->is_active = 1;

            if ($model->save()) {
                if($id != null){
                    $response['message'] = "Водитель изменен";
                }else{
                    $response['message'] = "Водитель успешно добавлен";
                }
                if($facs != null){
                    (new Query)
                        ->createCommand()
                        ->delete('drivers_facilities', ['driver_id' => $model->id])
                        ->execute();

                    foreach ($facs as $v){
                        if($v != 0){
                            $facility = new DriversFacilities();
                            $facility->driver_id = $model->id;
                            $facility->facility_id = $v;
                            $facility->save();
                        }
                    }
                }

                    (new Query)
                        ->createCommand()
                        ->delete('drivers_services', ['driver_id' => $model->id])
                        ->execute();

                foreach ($servcs as $v){
                    if($v != 0){
                        $service = new DriversServices();
                        $service->driver_id = $model->id;
                        $service->service_id = $v;
                        $service->save();
                    }
                }




                if($_POST['access'] == 'on'){

                    $try = UsersPrivileges::find()->where(['user_id' => $model->id])->one();
                    if($try == null){
                        $us = new UsersPrivileges();
                        $us->user_id = $model->id;
                        $us->privilege_id = $model->service_id;
                        $us->save();
                        $tp = TaxiParkPrivileges::find()->where(['taxi_park_id' => $model->taxi_park_id])->andWhere(['service_id' => $model->service_id])->one();
                        $tp->amount = $tp->amount - 1;
                        $tp->save();
                    }

                }else{
                    $us = UsersPrivileges::find()->where(['user_id' => $model->id])->one();
                    if($us != null){
                        (new Query)
                            ->createCommand()
                            ->delete('users_privileges', ['user_id' => $model->id])
                            ->execute();
                    }
                }


                $response['type'] = "success";

            } else {
                $response['message'] = "Неизвестная ошибка, попробуйте позже.";
                $response['type'] = "error";
            }


            return $response;
        }



    }






    public function actionDispatcher()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if ($id != null) {
                $model = Users::find()->where(['id' => $id])->one();
            } else {
                $user = Users::find()->where(['email' => $_POST['Information']['email']])->one();
                if ($user != null) {
                    $response['message'] = "Пользователь с таким email уже зарегистрирован.";
                    $response['type'] = "error";
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $response;
                }
                $model = new Users();

            }

            $model->attributes = $_POST['Information'];
            $model->taxi_park_id = $_POST['tp'];
            $model->last_edit = date("d/m/Y H:i:s", time());
            $model->created = strtotime("now");
            $model->password = md5($_POST['Information']['password']);
            $model->role_id = 8;
            $model->is_active = 1;

            if ($model->save()) {
                if($id != null){
                    $response['message'] = "Диспетчер изменен";
                }else{
                    $response['message'] = "Диспетчер успешно добавлен";
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



    public function actionCashier()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if ($id != null) {
                $model = Users::find()->where(['id' => $id])->one();
            } else {
                $user = Users::find()->where(['email' => $_POST['Information']['email']])->one();
                if ($user != null) {
                    $response['message'] = "Пользователь с таким email уже зарегистрирован.";
                    $response['type'] = "error";
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $response;
                }
                $model = new Users();

            }

            $model->attributes = $_POST['Information'];
            $model->last_edit = date("d/m/Y H:i:s", time());
            $today = getdate();
            $model->created = strtotime("now");
            $model->password = md5($_POST['Information']['password']);
            $model->role_id = 6;
            $model->taxi_park_id = 0;

            if ($model->save()) {
                if($id != null){
                    $response['message'] = "Кассир изменен";
                }else{
                    $response['message'] = "Кассир успешно добавлен";
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



    public function actionGetModels(){
        $models = CarModels::find()->where(['parent_id' => $_POST['id']])->all();

        $response['models'] = $models;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }

}

?>