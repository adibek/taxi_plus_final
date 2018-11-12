<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Orders extends ActiveRecord
{

    public static function tableName() {
        return "orders";
    }

    public function rules()
    {
        return [
            [['id', 'is_rated', 'payment_type', 'user_id', 'driver_id', 'taxi_park_id', 'from_latitude', 'from_longitude', 'to_latitude', 'to_longitude', 'order_type', 'is_common', 'last_edit', 'comment', 'status', 'created', 'price', 'date', 'company_id'], 'safe'],
        ];
    }
}
