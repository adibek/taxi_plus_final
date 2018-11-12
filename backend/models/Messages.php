<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Messages extends ActiveRecord
{

    public static function tableName() {
        return "messages";
    }

    public function rules()
    {
        return [
            [['id', 'author_id', 'reciever_id', 'text', 'created'], 'safe'],
        ];
    }
}
