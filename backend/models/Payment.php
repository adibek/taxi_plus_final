<?php

namespace backend\models;
use yii\db\ActiveRecord;


class Payment extends ActiveRecord
{

    public static function tableName() {
        return "payments";
    }

    public function rules()
    {
        return [
            [['id', 'order_id', 'session_id', 'payment_id', 'status', 'created'], 'safe'],
        ];
    }

}
