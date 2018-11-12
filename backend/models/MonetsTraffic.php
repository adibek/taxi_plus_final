<?php

namespace backend\models;

use yii\db\ActiveRecord;


class MonetsTraffic extends ActiveRecord
{

    public static function tableName() {
        return "monets_traffic";
    }

    public function rules()
    {
        return [
            [['id', 'sender_user_id', 'sender_tp_id', 'amount', 'reciever_user_id', 'reciever_tp_id', 'amount', 'date', 'process'], 'safe'],
        ];
    }
}
