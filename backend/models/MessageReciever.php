<?php

namespace backend\models;

use yii\db\ActiveRecord;


class MessageReciever extends ActiveRecord
{

    public static function tableName() {
        return "message_recievers";
    }

    public static function tableFields(){
        return ['id', 'reciever_id', 'read'];
    }

    public function rules()
    {
        return [
            [self::tableFields(), 'safe'],
        ];
    }
}
