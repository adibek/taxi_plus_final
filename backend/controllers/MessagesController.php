<?php
namespace backend\controllers;
use backend\components\Helpers;
use backend\models\Log;
use backend\models\Message;
use backend\models\MessageReciever;
use backend\models\SystemUsers;
use backend\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use backend\models\Company;

class MessagesController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $id = $_POST['id'];
            if ($id != null) {
                $model = Message::find()->where(['id' => $id])->one();
            } else {
                $model = new Message();
            }
            $model->attributes = $_POST['Information'];
            $model->sender_id = Yii::$app->session->get('profile_id');
            $model->created = strtotime('now');
            $recievers = [];
            if($_POST['roles'] == 0){
                if($_POST['tps'] == 000){
                    $recievers = SystemUsers::find()->all();
                }else{
                    $recievers = SystemUsers::find()->andWhere(['taxi_park_id' => $_POST['tps']])->all();
                }

            }else{
                if($_POST['roles'] == 1 OR $_POST['roles'] == 2) {
                    if($_POST['tps'] == 000){
                        $users = Users::find()->where(['role_id' => $_POST['roles']])->all();
                    }else{
                        $users = Users::find()->where(['role_id' => $_POST['roles']])->andWhere(['taxi_park_id' => $_POST['tps']])->all();
                    }
                    foreach ($users as $k => $v){
                        $not = array("title" => $_POST['Information']['title'], "message" => $_POST['Information']['text']);

                        if($v->platform == 1){
                            $data = array('to' => $v->push_id, 'notification' => $not);

                        }else{
                            $data = array('to' => $v->push_id, 'data' => $not);
                        }


                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-type: application/json',
                            'Authorization: key=AIzaSyCzke3IVnyVWY3aFz9TcGZU2yVd4cctQvk'
                        ));
                        curl_setopt($ch, CURLOPT_URL,"https://fcm.googleapis.com/fcm/send");
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,
                            json_encode($data));

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $server_output = curl_exec ($ch);
                        curl_close ($ch);
                        $log = new Log();
                        $log->response = $server_output;
                        $log->comment = 'Информативное письмо для' . $v->name ;
                        $log->save();
                    }
                }

                if($_POST['tps'] == 000){
                    $recievers = SystemUsers::find()->where(['role_id' => $_POST['roles']])->all();
                }else{
                    $recievers = SystemUsers::find()->where(['role_id' => $_POST['roles']])->andWhere(['taxi_park_id' => $_POST['tps']])->all();
                }
            }

            if($model->save()){
                foreach ($recievers as $k => $v){
                    $reciever = new MessageReciever();
                    $reciever->reciever_id = $v->id;
                    $reciever->message_id = $model->id;
                    $reciever->save();
                }
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

    public function actionReadMessage(){
        $id = $_POST['id'];
        $model = MessageReciever::findOne(['message_id' => $id, 'reciever_id' => Yii::$app->session->get('profile_id')]);
        $model->read = 1;
        $model->save();
    }

}

?>