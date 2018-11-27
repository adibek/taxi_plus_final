<?php
namespace backend\controllers;

use backend\components\Helpers;
use backend\models\Cities;
use backend\models\Company;
use backend\models\Message;
use backend\models\Orders;
use backend\models\SystemUsers;
use backend\models\SystemUsersCities;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use backend\models\Users;
use backend\models\TaxiPark;


class LoadajaxController extends Controller
{
    public function actionGetpage() {
        if (Yii::$app->request->isAjax) {
            if (Helpers::CheckAuth("check", null)) {
                $page = $_POST['page'];
                Yii::$app->session->set('navigation_page', $page);
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'back',
                    'value' => $page
                ]));

                if ($page == "account") {
                    $model = Users::find()->where(['id' => Yii::$app->session->get('profile_id')])->one();
                }

                if (Helpers::GetPageAccess($page)) {
                    return $this->renderPartial('/tables/' . $page . '/index', array('model' => $model, 'page' => $page));
                } else {
                    return $this->renderPartial('/system/access-denied');
                }
            } else {
                return 101;
            }
        }
    }

    public function actionGetaction() {
        if (Yii::$app->request->isAjax) {
            if (Helpers::CheckAuth("check", null)) {

                if ($_POST['id'] != null) {
                    $id = $_POST['id'];
                } else {
                    $id = 0;
                }
                $security = true;
                $page = $_POST['page'];
                Yii::$app->session->set('navigation_page', $page);

                if ($page == "moderators/form-moderator") {
                    $model = SystemUsers::find()->where(['id' => $id])->one();
                }else if ($page == "admins/form-admin") {
                    $model = SystemUsers::find()->where(['id' => $id])->one();
                }
                else if ($page == "tadmins/form-tadmin") {
                    $model = SystemUsers::find()->where(['id' => $id])->one();
                }
                else if ($page == "taxi-parks/form-taxi-park") {
                    $model = TaxiPark::find()->where(['id' => $id])->one();
                }
                else if ($page == "cashier/form-taxi-park") {
                    $model = TaxiPark::find()->where(['id' => $id])->one();
                }
                else if ($page == "cashiers/form-cashier") {
                    $model = Users::find()->where(['id' => $id])->one();
                }
                else if ($page == "drivers/form-driver") {
                    $model = Users::find()->where(['id' => $id])->one();
                }
                else if ($page == "messages/message") {
                    $model = Message::find()->where(['id' => $id])->one();
                }
                else if ($page == "taxi-parks/radial") {
                    $model = TaxiPark::find()->where(['id' => $id])->one();
                }
                else if ($page == "companies/form-company") {
                    $model = Company::find()->where(['id' => $id])->one();
                }
                else if ($page == "stats-tp/tp-stat") {
                    $model = TaxiPark::find()->where(['id' => $id])->one();
                    $info = $_POST['info'];
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "info" => $info, "security" => $security));
                }
                else if ($page == "stats-companies/company-stat") {
                    $model = Company::find()->where(['id' => $id])->one();
                    $info = $_POST['info'];
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "info" => $info, "security" => $security));
                }
                else if ($page == "stats-drivers/driver-stat") {
                    $model = Users::find()->where(['id' => $id])->one();
                    $info = $_POST['info'];
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "info" => $info, "security" => $security));
                }
                else if ($page == "stats-clients/client-stat") {
                    $model = Users::find()->where(['id' => $id])->one();
                    $info = $_POST['info'];
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "info" => $info, "security" => $security));
                }
                else if ($page == "cadmins/form-admin") {
                    $model = SystemUsers::find()->where(['id' => $id])->one();
                }
                else if ($page == "orders/orders-list") {
                    $type = $_POST['id'];
                    $info = $_POST['info'];
                    return $this->renderPartial('/tables/' . $page, array("type" => $type, "info" => $info, "security" => $security));

                }
                else if ($page == "dispatchers/orders") {
                    $type = $_POST['id'];

                    return $this->renderPartial('/tables/' . $page, array("type" => $type, "security" => $security));

                }
                else if ($page == "admins/moderators") {
                    if($id == 0){
                        $model = "";
                        $cities = Cities::find()->all();
                        foreach ($cities as $k => $v){
                            if($k < (count($cities) - 1)){
                                $model .= $v->id . ', ';
                            }else{
                                $model .= $v->id;
                            }
                        }
                        return $this->renderPartial('/tables/' . $page, array("model" => $model, "security" => $security));
                    }
                    $cities = SystemUsersCities::find()->where(['system_user_id' => $id])->all();
                    $model = "";
                    foreach ($cities as $k => $v){
                        if($k < (count($cities) - 1)){
                            $model .= $v->city_id . ', ';
                        }else{
                            $model .= $v->city_id;
                        }
                    }
                    $admin = SystemUsers::findOne(['id' => $id]);
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "security" => $security, 'admin' => $admin));

                }
                else {
                    $model = null;
                }

                if ($model != null) {
                    return $this->renderPartial('/tables/' . $page, array("model" => $model, "security" => $security));
                } else {
                    return $this->renderPartial('/tables/' . $page, array("security" => $security, 'model' => null));
                }
            } else {
                return 101;
            }
        }
    }

    public function actionFiltrlink() {
        if (Yii::$app->request->isAjax) {
            if (Helpers::CheckAuth("check", null)) {
                $id = $_POST['id'];
                $page = $_POST['page'];
                $array = Yii::$app->session->get('filtr');
                if ($page == "sellers") {
                    $array[$page]['rod_id'] = $id;
                } else if ($page == "shops") {
                    $array[$page]['user_id'] = $id;
                } else if ($page == "products") {
                    $array[$page]['shop_id'] = $id;
                }
                Yii::$app->session->set('filtr', $array);
                $response['type'] = "success";
            } else {
                $response['type'] = "information";
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }

}
