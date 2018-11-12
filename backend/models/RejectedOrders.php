<?php

namespace backend\models;

use yii\db\ActiveRecord;


class RejectedOrders extends ActiveRecord
{

    public static function tableName() {
        return "rejected_orders";
    }

    public function rules()
    {
        return [
            [['id', 'order_id', 'user_id', 'created'], 'safe'],
        ];
    }
}
