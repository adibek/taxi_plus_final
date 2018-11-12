<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/19/18
 * Time: 11:34 AM
 */
namespace backend\models;

use yii\db\ActiveRecord;


class SpecificOrdersClient extends ActiveRecord
{

    public static function tableName() {
        return "specific_orders_clients";
    }

    public function rules()
    {
        return [
            [['id', 'order_id', 'client_id', 'seats_number', 'created'], 'safe'],
        ];
    }

}
