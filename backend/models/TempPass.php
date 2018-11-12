<?php

namespace backend\models;

use yii\db\ActiveRecord;


class TempPass extends ActiveRecord
{

    public static function tableName() {
        return "temporary_passwords";
    }

    public function rules()
    {
        return [
            [['id', 'phone', 'code'], 'safe'],
        ];
    }
}
