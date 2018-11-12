<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Roles extends ActiveRecord
{

    public static function tableName() {
        return "roles";
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
        ];
    }
}
