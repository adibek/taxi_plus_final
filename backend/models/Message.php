<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Message extends ActiveRecord
{

    public static function tableName() {
        return "messages";
    }

    public static function tableFields(){
        return ['id', 'sender_id', 'title', 'text', 'created', 'last_edit'];
    }

    public function rules()
    {
        return [
            [self::tableFields(), 'safe'],
        ];
    }
}
