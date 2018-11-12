<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Sessions extends ActiveRecord
{

    public static function tableName() {
        return "sessions";
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'start', 'end', 'type'], 'safe'],
        ];
    }
}
