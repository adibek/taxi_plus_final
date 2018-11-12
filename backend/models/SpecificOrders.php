<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/19/18
 * Time: 11:18 AM
 */
namespace backend\models;
use backend\models\SpecificOrdersClient;
use yii\db\ActiveRecord;


class SpecificOrders extends ActiveRecord
{

    public static function tableName() {
        return "specific_orders";
    }

    public function rules()
    {
        return [
            [['id', 'order_type_id', 'start_id', 'destination_id', 'from_string', 'to_string', 'driver_id', 'created'], 'safe'],
        ];
    }
    public static function addIntercityOrder($token, $number, $start, $end, $price, $date){
        $order = new SpecificOrders();
        $order->order_type_id = 1;
        $order->start_id = $start;
        $order->destination_id = $end;
        $order->date = $date;
        $order->price = $price;
        $order->save();
        $client = new \backend\models\SpecificOrdersClient();
        $client->seats_number = $number;
        $client->order_id = $order->id;
        $user = Users::findOneUser($token);
        $client->client_id = $user->id;
        $client->save();
    }
    public static function addOtherOrder($token, $comment, $start, $end, $price, $date, $type){
        $order = new SpecificOrders();
        $order->order_type_id = $type;
        $order->from_string = $start;
        $order->to_string = $end;
        $order->date = $date;
        $order->price = $price;
        $order->comment = $comment;
        $order->save();
        $client = new \backend\models\SpecificOrdersClient();
        $client->order_id = $order->id;
        $user = Users::findOneUser($token);
        $client->client_id = $user->id;
        $client->save();
    }
}
