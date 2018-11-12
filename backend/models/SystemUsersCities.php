<?php

namespace backend\models;

use yii\db\ActiveRecord;


class SystemUsersCities extends ActiveRecord
{

    public static function tableName() {
        return "system_users_cities";
    }

    public static function tableFields(){
        return ['id', 'city_id', 'system_user_id', 'last_edit', 'created'];
    }

    public function rules()
    {
        return [
            [self::tableFields(), 'safe'],
        ];
    }
}
