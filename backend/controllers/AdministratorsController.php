<?php
namespace backend\controllers;
use Yii;
//use yii\db\query;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use backend\models\SystemUsers;
use backend\models\SystemUsersCities;
use yii\web\Response;

class AdministratorsController extends Controller
{
    public function actionIndex()
    {

        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            if($id == null){
                $model = new SystemUsers();
            }else{
                $model = SystemUsers::findOne($id);
            }
            $model->role_id = 3;
            $model->taxi_park_id = 0;
            $model->created = strtotime('now');
            $model->attributes = $_POST['Information'];

                if($model->save()){
                    $cities = explode(",", $_POST['cities']);
                    try {
                        (new Query)
                            ->createCommand()
                            ->delete('system_users_cities', ['system_user_id' => $model->id])
                            ->execute();
                    } catch (Exception $e) {
                        print_r($e);
                    }
                    foreach ($cities as $city){
                        if($city != null){
                            $sys_city = new SystemUsersCities();
                            $sys_city->system_user_id = $model->id;
                            $sys_city->city_id = $city;
                            $sys_city->created = strtotime('now');
                            $sys_city->save();
                        }
                    }
                    if($id == null){
                        $response['message'] = "Администратор успешно добавлен";
                        $response['type'] = "success";
                    }else{
                        $response['message'] = "Администратор успешно изменен";
                        $response['type'] = "success";
                    }

                }else{
                    print_r($model->getErrors());
                    $response['message'] = $model->getErrors();
                    $response['type'] = "error";
                }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }

        }


}