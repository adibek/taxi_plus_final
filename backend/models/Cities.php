<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Cities extends ActiveRecord
{

    public static function tableName() {
        return "cities";
    }

    public function rules()
    {
        return [
            [['id', 'cname', 'region_id'], 'safe'],
        ];
    }
}
