<?php

namespace backend\models;

use yii\db\ActiveRecord;


class DriversFacilities extends ActiveRecord
{

    public static function tableName() {
        return "drivers_facilities";
    }

    public function rules()
    {
        return [
            [['id', 'driver_id', 'facility_id'], 'safe'],
        ];
    }
}
