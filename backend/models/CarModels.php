<?php

namespace backend\models;
use backend\models\UsersCars;
use backend\models\Users;
use yii\db\ActiveRecord;


class CarModels extends ActiveRecord
{

    public static function tableName() {
        return "car_models";
    }

    public function rules()
    {
        return [
            [['id', 'model', 'parent_id'], 'safe'],
        ];
    }
    public static function findMyCar($user_id){
        $car = \backend\models\UsersCars::find()->where(['user_id' => $user_id])->andWhere(['type' => 1])->one();
        return $car;
    }
}
