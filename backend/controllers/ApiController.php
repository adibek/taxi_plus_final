<?php
namespace backend\controllers;
use Functions;
use Yii;
use yii\web\Controller;
use backend\models\Users;
use backend\models\Messages;
use backend\models\Orders;
use backend\models\SavedAddresses;
use backend\models\PossibleDrivers;
use yii\web\Response;
use yii\web\User;

class ApiController extends Controller
{



    public $enableCsrfValidation = false;

    public function actionCheckPhone(){
        $auth_key = Yii::$app->security->generateRandomString();
        $phone = $_POST['phone'];
        $user = Users::find()->where(['phone' => $phone])->one();

        if($user != null){
            Yii::$app->response->statusCode = 200;
            $user->token = $auth_key;
            $user->save();
            $response["state"] = 'success';
            $response["type"] = $user->type;
            $response["token"] = $auth_key;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }else{
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["message"] = 'user not found';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }

    }


    public function actionSignUp(){
        $auth_key = Yii::$app->security->generateRandomString();
        $phone = $_POST['phone'];
        $name = $_POST['name'];
        if($phone == null OR $name == null){
            Yii::$app->response->statusCode = 400;
            $response["state"] = 'fail';
            $response["message"] = 'name or phone is missing';
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $response;
        }

        $user = new Users();
        $user->role_id = 1;
        $user->name = $name;
        $user->phone = $phone;
        $user->created = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
        $user->last_edit = Yii::$app->formatter->asDate(date('Y-d-m h:i:s'));
        $user->last_visit = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
        $user->token = $auth_key;
        if($user->save()){
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["message"] = 'Authorized';
            $response["token"] = $auth_key;
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $response;

        }else{
            Yii::$app->response->statusCode = 400;
            $response["state"] = 'fail';
            $response["message"] = 'Occured some errors, ask Tair';
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $response;
        }
    }




    public function actionUploadAvatar(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $token = $_POST["token"];

        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){

            $target_dir = "assets/images/avatars";

            if(!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $target_dir = $target_dir . "/" . basename($_FILES["file"]["name"]);

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir))
            {
                $user->avatar_path = basename($_FILES["file"]["name"]);
                if($user->save()){

                    $response["state"] = 'success';
                    $response["path"] =  basename( $_FILES["file"]["name"]);

                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return $response;
                }
            } else {
                $response["state"] = 'fail';
                $response["message"] = 'some errors happened';

                Yii::$app->response->format = Response::FORMAT_JSON;

                return $response;


            }
        }else{
            Yii::$app->response->statusCode = 401;

            $response["state"] = 'fail';
            $response["message"] = 'Invalid token';
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $response;
        }

    }


    public function actionMakeOrder(){

        $token = $_POST['token'];
        $to_long = $_POST['to_longitude'];
        $to_lat = $_POST['to_latitude'];
        $from_long = $_POST['from_longitude'];
        $from_lat = $_POST['from_latitude'];
        $type = $_POST['order_type'];
        $comment = $_POST['comment'];
        $date = $_POST['date'];
        $pay = $_POST['payment_type'];
        $price = $_POST['price'];

        if($token != null AND $to_lat != null AND $to_long != null AND $from_lat != null AND $from_long != null){
            $user = Users::find()->where(['token' => $token])->one();
            if($user != null){
                $order = new Orders();
                $order->user_id = $user->id;
                $order->from_latitude = $from_lat;
                $order->from_longitude = $from_long;
                $order->to_latitude = $to_lat;
                $order->to_longitude = $to_long;
                $order->order_type = $type;
                $order->comment = $comment;
                if($price != null){
                    $order->price = $price;
                }
                if($date != null){
                    $order->date = $date;
                }

                $order->created = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
                if($order->save()){
                    // ask drivers
                    $all_drivers = Users::find()->where(['role_id' => 2])->all();
                    foreach ($all_drivers as $key => $value){
                        // send silent notification
                    }

                    Yii::$app->response->statusCode = 200;
                    $response["state"] = 'success';
                    $response["message"] = 'Order in processing';
                    Yii::$app->response->format = Response::FORMAT_JSON;


                    ignore_user_abort(true);
                    set_time_limit(0);

                    ob_start();
                    echo '{
                        "state" : "success"
                    }'; // send the response
                    header('Connection: close');
                    header('Content-Length: '.ob_get_length());
                    ob_end_flush();
                    ob_flush();
                    flush();

                    sleep(60);

                    // check if there some drivers
                    

                    $updated_order = Orders::find()->where(['id' => $order->id])->one();
                    if($updated_order->driver_id == null){
                        if($updated_order->status == 1){
                            $updated_order->is_common = 1;
                            // send push to all drivers
                        }

                    }

                }

            }else{
                Yii::$app->response->statusCode = 401;

                $response["state"] = 'fail';
                $response["message"] = 'Invalid token, user not found';
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $response;
            }

        }


    }

    public function actionCheckLocation(){
        $my_long = $_POST['longitude'];
        $my_lat = $_POST['latitude'];
        $token = $_POST['token'];
        $order_id = $_POST['order_id'];

        $order = Orders::find()->where(['id' => $order_id])->one();

        $distance = $this->haversineGreatCircleDistance($my_lat, $my_long, $order->from_latitude, $order->from_longitude);
        if($distance < 1000){
            // send push to that driver
        }

    }


    public function actionAcceptOrder(){

        $token = $_POST['token'];
        $order_id = $_POST['order_id'];

        $order = Orders::find()->where(['id' => $order_id])->andWhere(['driver_id' => null])->one();
        $driver = Users::find()->where(['token' => $token])->one();
        if($order != null){
            if($driver != null){
                if($driver->role_id == 2){

                    $model = new PossibleDrivers();
                    $model->driver_id = $driver->id;
                    $model->order_id = $order_id;
                    $model->save();
                    Yii::$app->response->statusCode = 200;

                    $response["state"] = 'success';
                    $response["message"] = 'Wait for client`s answer';
                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return $response;

                }else{
                    Yii::$app->response->statusCode = 400;

                    $response["state"] = 'fail';
                    $response["message"] = 'You cannot accept that order';
                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return $response;
                }
            }else{
                Yii::$app->response->statusCode = 401;

                $response["state"] = 'fail';
                $response["message"] = 'Invalid token, user not found';
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $response;
            }
        }else{
            Yii::$app->response->statusCode = 400;

            $response["state"] = 'fail';
            $response["message"] = 'That order is not available';
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $response;
        }

    }



    public function actionAcceptDriver(){
        $driver_id = $_POST['driver_id'];
        $order_id = $_POST['order_id'];
        $order = Orders::find()->where(['id' => $order_id])->one();
        if($order-> driver_id == null){
            $order->driver_id =  $driver_id;
            $order->save();
        }

    }


    public function actionSaveAddress(){
        $token = $_POST['token'];
        $address = $_POST['address'];
        $long = $_POST['longitude'];
        $lat = $_POST['latitude'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){
            $model = new SavedAddresses();
            $model->address = $address;
            $model->longitude = $long;
            $model->latitude = $lat;
            $model->user_id = $user->id;

            if($model->save()){
                Yii::$app->response->statusCode = 200;
                $response["state"] = 'sussess';
                $response["message"] = 'Address saved';
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $response;
            }else{
                Yii::$app->response->statusCode = 400;
                $response["state"] = 'fail';
                $response["message"] = 'Some error happened';
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $response;
            }

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }

    }

    public function actionGetAvatar(){

        $token = $_POST['token'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["avatar"] = $user->avatar_path;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }



    public function actionGetOrders(){

        $token = $_POST['token'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user == null){
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
        $orders = Orders::find()->where(['user_id' => $user->id])->andWhere(['status' => 3])->all();
        if($orders != null){
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["orders"] = $orders;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 400;
            $response["state"] = 'fail';
            $response["message"] = 'There are no orders';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }


    public function actionGetActiveOrders(){

        $token = $_POST['token'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user == null){
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
        $orders = Orders::find()->where(['user_id' => $user->id])->andWhere(['status' => 0])->all();
        if($orders != null){
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["orders"] = $orders;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 400;
            $response["state"] = 'fail';
            $response["message"] = 'There are no orders';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }


    public function actionGetAddresses(){

        $token = $_POST['token'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){
            $addresses = SavedAddresses::find()->where(['user_id' => $user->id])->all();
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["addresses"] = $addresses;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }




    }


    public function actionGetBonuses(){

        $token = $_POST['token'];

        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){
            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            $response["balance"] = $user->balance;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }




    }

    public function actionClearAll(){
        $tables = array('users', 'orders', 'messages', 'possible_drivers', 'saved_addresses');
        foreach ($tables as $value){
            Yii::$app->db->createCommand()->truncateTable($value)->execute();
        }
    }

    public function actionGetProfileInfo(){
        $token = $_POST['token'];
        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Incorrect token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }

    }

    public function actionSetPushId(){
        $token = $_POST['token'];
        $push_id = $_POST['push_id'];
        if($token == null OR $push_id == null){
            Yii::$app->response->statusCode = 400;
            $response["state"] = 'fail';
            $response["message"] = 'Requered fields are missing: token or push_id';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
        $user = Users::find()->where(['token' => $token])->one();
        if($user != null){
            $user->push_id = $push_id;
            $user->save();

            Yii::$app->response->statusCode = 200;
            $response["state"] = 'success';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;

        }else{
            Yii::$app->response->statusCode = 401;
            $response["state"] = 'fail';
            $response["message"] = 'Invalid token';
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }


    }


    public function actionTest()
    {
        $response['message'] = "Сессия устарела, перезайдите.";
        $response['type'] = "information";
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }

    function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

}
