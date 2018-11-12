<?php

namespace backend\models;

use yii\db\ActiveRecord;


class WorkingTypes extends ActiveRecord
{

    public static function tableName() {
        return "working_types";
    }

    public function rules()
    {
        return [
            [['id', 'description'], 'safe'],
        ];
    }
}
