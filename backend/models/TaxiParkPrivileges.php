<?php

namespace backend\models;

use yii\db\ActiveRecord;


class TaxiParkPrivileges extends ActiveRecord
{

    public static function tableName() {
        return "taxi_park_privileges";
    }

    public function rules()
    {
        return [
            [['id', 'service_id', 'taxi_park_id', 'amount'], 'safe'],
        ];
    }
}
