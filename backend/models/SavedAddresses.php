<?php

namespace backend\models;

use yii\db\ActiveRecord;


class SavedAddresses extends ActiveRecord
{

    public static function tableName() {
        return "saved_addresses";
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'address', 'latitude','longitude'], 'safe'],
        ];
    }
}
