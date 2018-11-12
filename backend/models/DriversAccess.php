<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/19/18
 * Time: 1:51 PM
 */

namespace backend\models;
use backend\models\UsersCars;
use backend\models\Users;
use yii\db\ActiveRecord;


class DriversAccess extends ActiveRecord
{

    public static function tableName() {
        return "drivers_access";
    }

    public function rules()
    {
        return [
            [['id', 'driver_id', 'order_type_id', 'until'], 'safe'],
        ];
    }
}
