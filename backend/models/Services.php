<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Services extends ActiveRecord
{

    public static function tableName() {
        return "services";
    }

    public function rules()
    {
        return [
            [['id', 'value', 'icon', 'icon1', 'referal_price'], 'safe'],
        ];
    }
}
