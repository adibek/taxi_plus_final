<?php
namespace backend\controllers;
use backend\models\Company;
use backend\models\SpecificOrders;
use backend\models\SystemUsers;
use backend\models\Orders;
use backend\models\Queries;
use backend\models\SystemUsersCities;
use backend\models\TaxiPark;
use backend\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use backend\components\Helpers;
use backend\models\MonetsTraffic;

class TablesController extends Controller
{
    public function actionGettable()
    {
        if (Yii::$app->request->isAjax) {
            $table = $_POST['table'];
            $name = $_POST['name'];
            $other = (array)$_POST['other'];
            $config = Helpers::GetConfig($name, "select_fields");
            $draw = $_GET['draw'];      //Текущая страница
            $start = $_GET['start'];    //С какой записи
            $length = $_GET['length'];  //Количество записей на страницу
            $search = $_GET['search']['value'];  //Поиск
            $order = $_GET['order'][0]; //Сортировка


//            $query = null;
            $filtr = Yii::$app->session->get('filtr');

            /* -------------- ВНЕДРЕНИЕ */
            if (Yii::$app->session->get('profile_role') != 3) {

                if (Yii::$app->session->get('profile_role') == 5) {
                    if ($name == "taxi-parks") {
                        $query = "taxi_park.id = " . Yii::$app->session->get('profile_tp'); //Видят только дилеры
                    }
                }
            }

            $arr_date = array();


            if ($filtr[$name] != null) {
                $condition = null;
                foreach ($filtr[$name] as $key => $value) {
                    if (count($value) <= 1) {
                        if ($condition == null) {
                            $condition .= $table . "." . $key . " = '" . $value . "'";
                        } else {
                            $condition .= " AND " . $table . "." . $key . " = '" . $value . "'";
                        }
                    } else {
                        foreach ($value as $d => $date) {
                            if ($arr_date[$key]['start'] == null) {
                                $query .= " " . $table . "." . $key . " >= " . $date;
                                $arr_date[$key]['start'] = $date;
                            } else {
                                $query .= " AND " . $table . "." . $key . " <= " . $date;
                                $arr_date[$key]['end'] = $date;
                            }
                        }
                    }
                }
            }
            if ($other != null) {
                foreach ($other as $key => $value) {
                    $condition[$key] = $value;
                }
            }
            if ($condition == null) {
                $condition = $table . ".id IS NOT NULL";
            }

//            print_r('q' . $query . ' c ' . $condition); die();
            if ($name == "moderators") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`id`,
                       `name`,
                         `phone`,
                         `last_edit`,
                         `created`,
                         `email`
                        '
                    )
                    ->from($table)
                    ->where(['role_id' => 4])
                    ->all();
            } else if ($name == "admins") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`id`,
                         `name`,
                         `phone`,
                         `last_edit`,
                         `created`,
                         `email`'
                    )
                    ->from($table)
                    ->andWhere($query)
                    ->where(['role_id' => 3])
                    ->all();
            }
            else if ($name == "cadmins") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`users`.`id`,
                         `users`.`name`,
                         `users`.`phone`,
                         `company`.`name` AS cname,
                         `users`.`created`'
                    )
                    ->from($table)
                    ->andWhere($query)
                    ->where(['role_id' => 7])
                    ->innerJoin('company', 'users.company_id = company.id')
                    ->all();
            }
            else if ($name == "users") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`id`,
                         `name`,
                         `phone`,
                         `last_edit`,
                         `created`,
                         `email`,
                         `is_active`'
                    )
                    ->from($table)
                    ->where(['role_id' => 1])
                    ->andWhere($condition)
                    ->all();
            }
            else if ($name == "coworkers") { //Producty
                $myId = Yii::$app->session->get('profile_id');
                $me = Users::find()->where(['id' => $myId])->one();
                $model = (new \yii\db\Query())
                    ->select('`id`,
                         `name`,
                         `phone`,
                         `last_edit`,
                         `created`,
                         `email`,
                         `is_active`,
                         `company_id`'
                    )
                    ->from($table)
                    ->where(['role_id' => 1])
                    ->andWhere(['company_id' => $me->company_id])
                    ->andWhere($condition)
                    ->all();
            }
            else if ($name == "aworkers") { //Producty
                $myId = Yii::$app->session->get('profile_id');
                $me = Users::find()->where(['id' => $myId])->one();
                $model = (new \yii\db\Query())
                    ->select('`id`,
                         `name`,
                         `phone`,
                         `last_edit`,
                         `created`,
                         `email`,
                         `is_active`,
                         `company_id`'
                    )
                    ->from($table)
                    ->where(['role_id' => 1])
                    ->andWhere(['company_id' => NULL])
                    ->andWhere($condition)
                    ->all();
            }

            else if ($name == "dispatchers") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`users`.`id`,
                         `users`.`name`,
                         `users`.`phone`,
   
                         `taxi_park`.`name` AS tname,
                         `users`.`created`'
                    )
                    ->from($table)
                    ->where(['role_id' => 8])
                    ->andWhere($condition)
                    ->innerJoin('taxi_park', '`taxi_park`.`id` = `users`.`taxi_park_id`')
                    ->all();
            }

            else if ($name == "tadmins") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`users`.`id`,
                         `users`.`name`,
                         `users`.`phone`,
                         `users`.`last_edit`,
                         `users`.`created`,
                         `users`.`email`,
                         `taxi_park`.`name` AS tname'
                    )
                    ->from($table)
                    ->where(['role_id' => 5])
                    //   ->andWhere($condition)
                    ->innerJoin('taxi_park', '`taxi_park`.`id` = `users`.`taxi_park_id`')
                    ->all();
            } else if ($name == "cashiers") { //Producty

                $model = (new \yii\db\Query())
                    ->select('`users`.`id`,
                         `users`.`name`,
                         `users`.`phone`,
                         `users`.`last_edit`,
                         `users`.`created`,
                         `users`.`email`,
                         `taxi_park`.`name` AS tname'
                    )
                    ->from($table)
                    ->where(['role_id' => 6])
                    ->innerJoin('taxi_park', '`taxi_park`.`id` = `users`.`taxi_park_id`')
                    ->all();
            } else if ($name == "taxi-parks" OR $name == "cashier") {


                $model = (new \yii\db\Query())
                    ->select('`taxi_park`.`id`,
                         `taxi_park`.`name`,
                         `taxi_park`.`balance`,
                         `cities`.`cname`,
                         `working_types`.`description`'
                    )
                    ->from($table)
                    ->where($query)
                    ->andWhere($condition)
                    ->innerJoin('cities', '`taxi_park`.`city_id` = `cities`.`id`')
                    ->innerJoin('working_types', '`working_types`.`id` = `taxi_park`.`type`')
                    ->all();
            } else if ($name == "drivers") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`users`.`id`,
                         `users`.`name`,
                         `users`.`phone`,
                         `users`.`created`,
                         `users`.`email`,
                         `users`.`is_active`,
                         `users`.`balance`,
                         `taxi_park`.`name` AS tname'
                    )
                    ->from($table)
                    ->where(['role_id' => 2])
                    // ->andWhere($condition)
                    ->innerJoin('taxi_park', '`taxi_park`.`id` = `users`.`taxi_park_id`')
                    ->all();
            } else if ($name == "traffic") { //Producty
                $model = (new \yii\db\Query())
                    ->select('`monets_traffic`.`id`,
                         `u1`.`name` AS sname,
                         `u2`.`name` AS rname,
                         `tp1`.`name` AS tps,
                         `tp2`.`name` AS tpr,
                         `monets_traffic`.`date`,
                         `monets_traffic`.`sender_user_id`,
                         `monets_traffic`.`sender_tp_id`,
                         `monets_traffic`.`reciever_tp_id`,
                         `monets_traffic`.`reciever_user_id`,
                         `monets_traffic`.`amount`,
                         `monets_traffic`.`process`'
                    )
                    ->from($table)
                    ->where($query)
                    ->innerJoin('users u1', '`u1`.`id` = `monets_traffic`.`sender_user_id`')
                    ->innerJoin('users u2', '`u2`.`id` = `monets_traffic`.`reciever_user_id`')
                    ->innerJoin('taxi_park tp1', '`tp1`.`id` = `monets_traffic`.`sender_tp_id`')
                    ->innerJoin('taxi_park tp2', '`tp2`.`id` = `monets_traffic`.`reciever_tp_id`')
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "companies") { //Producty

                $companies = Company::find()->all();
                $ar = [];
                foreach ($companies as $key => $value){
                    $arr['id'] = $value->id;
                    $arr['name'] = $value->name;
                    $arr['balance'] = $value->balance;
                    $arr['created'] = $value->created;
                    $user = Users::find()->where(['role_id' => 7])->andWhere(['company_id' => $value->id])->one();
                    $arr['username'] = $user->name;
                    array_push($ar, $arr);
                }

//                $model = (new \yii\db\Query())
//                    ->select('`company`.`id`,
//                         `company`.`name`,
//                         `company`.`balance`,
//                         `company`.`created`,
//                         `users`.`name`'
//                    )
//                    ->from($table)
//                    ->innerJoin('users', 'users.company_id = company.')
//                    ->all();
                $model = $ar;

            }
            else {

                $model = (new \yii\db\Query())
                    ->select($config)
                    ->from($table)
                    ->andWhere($condition)
                    ->andWhere($query)
                    ->all();
            }
            $data['data'] = array_map('array_values', $model);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
        }
    }

    public function actionFiltr()
    {
        if (Yii::$app->request->isAjax) {
            $page = $_POST['page'];
            $field = $_POST['field'];
            $value = $_POST['value'];

            $array = Yii::$app->session->get('filtr');
            if ($value == "all") {
                unset($array[$page][$field]);
            } else {
                $array[$page][$field] = $value;
            }
            if (count($array[$page]) <= 0) {
                unset($array[$page]);
            }
            Yii::$app->session->set('filtr', $array);
        }
    }

    public function actionFiltrdate()
    {
        if (Yii::$app->request->isAjax) {
            $page = $_POST['page'];
            $field = $_POST['field'];
            $start = $_POST['start'];
            $end = $_POST['end'];

            $array = Yii::$app->session->get('filtr');
            $array[$page][$field] = array("start" => strtotime($start), "end" => strtotime($end));
            if (count($array[$page]) <= 0) {
                unset($array[$page]);
            }
            Yii::$app->session->set('filtr', $array);
        }
    }

    public function actionDelfiltr()
    {
        if (Yii::$app->request->isAjax) {
            $page = $_POST['page'];
            $field = $_POST['field'];

            $array = Yii::$app->session->get('filtr');
            unset($array[$page][$field]);
            if (count($array[$page]) <= 0) {
                unset($array[$page]);
            }
            Yii::$app->session->set('filtr', $array);
        }
    }

    public function actionSavestate()
    {

        $response = array();
        foreach ($_POST as $key => $value) {
            if ($key == "time" OR $key == "start" OR $key == "length") {
                $response[$key] = intval($value);
            } else {
                $response[$key] = $value;
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->session->set('profile_state', array('products' => $_POST));
        return $response;
    }

    public function actionGetstate()
    {
        $page = 'monets_traffic';

        $state = Yii::$app->session->get('profile_state');
        if ($state[$page] == null) {
            $time = time() * 1000;
            $state[$page] = array(
                'time' => intval($time),
                'start' => 0,
                'length' => 10,
                'order' => array(
                    '0' => array(
                        '0' => 1,
                        '1' => 'asc'
                    ),
                ),
            );
            Yii::$app->session->set('profile_state', $state);
        }
        $state = Yii::$app->session->get('profile_state');
        $response = array();
        foreach ($state['monets_traffic'] as $key => $value) {
            if ($key == "time" OR $key == "start" OR $key == "length") {
                $response[$key] = intval($value);
            } else {
                $response[$key] = $value;
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }


    public function actionGetNewTable()
    {
        if (Yii::$app->request->isAjax) {
            $name = $_GET['name'];
            $table = $_GET['table'];
            $id = $_GET['id'];
            $draw = $_GET['draw'];      //Текущая страница
            $start = $_GET['start'];    //С какой записи
            $length = $_GET['length'];  //Количество записей на страницу
            $search = $_GET['search']['value'];  //Поиск
            $order = $_GET['order'][0]; //Сортировка

            $config = Helpers::GetConfig($name, "select_fields");
            $search_config = Helpers::GetConfig($name, "search_fields");
            $filtr = Yii::$app->session->get('filtr');

            $other = (array)$_POST['other'];
            $query = null;
            $condition = null;
            $search_condition = $table . '.id != 0';

            if ($order['dir'] == "asc") {
                $sort = SORT_ASC;
            } else {
                $sort = SORT_DESC;
            }

            $arr_date = array();


            /* -------------- ВНЕДРЕНИЕ */
            if (Yii::$app->session->get('profile_role') != 3) {
                if ($name == "orders") {
                    if (Yii::$app->session->get('profile_role') == 5) {
                        $query = $table . ".taxi_park_id = " . Yii::$app->session->get('profile_tp');
                    } else if (Yii::$app->session->get('profile_role') == 7) {
                        $query = $table . ".company_id = " . Yii::$app->session->get('company_id');
                    }
                }
            }


            if ($query == null) {
                $query = $table . ".id != -1";
            }



            if ($filtr[$name] != null) {
                foreach ($filtr[$name] as $key => $value) {
                    if (count($value) <= 1) {
                        if ($condition == null) {
                            $condition .= $table . "." . $key . " = '" . $value . "'";
                        } else {
                            $condition .= " AND " . $table . "." . $key . " = '" . $value . "'";
                        }
                    } else {
                        foreach ($value as $d => $date) {
                            if ($arr_date[$key]['start'] == null) {
                                $query .= " AND " . $table . "." . $key . " >= " . $date;
                                $arr_date[$key]['start'] = $date;
                            } else {
                                $query .= " AND " . $table . "." . $key . " <= " . $date;
                                $arr_date[$key]['end'] = $date;
                            }
                        }
                    }
                }
            }
            if ($other != null) {
                foreach ($other as $key => $value) {
                    if ($condition == null) {
                        $condition .= $table . "." . $key . " = '" . $value . "'";
                    } else {
                        $condition .= " AND " . $table . "." . $key . " = '" . $value . "'";
                    }
                }
            }

            if ($search != null AND $search_config != null) {
                $search_condition = null;
                foreach ($search_config as $value) {
                    if ($search_condition == null) {
                        $search_condition .= $table . "." . $value . " LIKE '%" . $search . "%'";
                    } else {
                        $search_condition .= " OR " . $table . "." . $value . " LIKE '%" . $search . "%'";
                    }
                }
            }
            if ($condition == null) {
                $condition = $table . ".id IS NOT NULL";
            }

//            print_r('q ' . $query);
//            print_r(' c ' .$condition);
//            die();

            if ($name == "traffic") { //Producty
                $recordsTotal = MonetsTraffic::find()->andWhere($query)->count();
                $recordsFiltered = MonetsTraffic::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('`monets_traffic`.`id`,
                         `u1`.`name` AS sname,
                         `u2`.`name` AS rname,
                         `tp1`.`name` AS tps,
                         `tp2`.`name` AS tpr,
                         `monets_traffic`.`date`,
                         `monets_traffic`.`sender_user_id`,
                         `monets_traffic`.`sender_tp_id`,
                         `monets_traffic`.`reciever_tp_id`,
                         `monets_traffic`.`reciever_user_id`,
                         `monets_traffic`.`amount`,
                         `monets_traffic`.`process`'
                    )
                    ->from($table)
                    ->where($query)
                    ->andWhere($condition)
                    ->innerJoin('users u1', '`u1`.`id` = `monets_traffic`.`sender_user_id`')
                    ->innerJoin('users u2', '`u2`.`id` = `monets_traffic`.`reciever_user_id`')
                    ->innerJoin('taxi_park tp1', '`tp1`.`id` = `monets_traffic`.`sender_tp_id`')
                    ->innerJoin('taxi_park tp2', '`tp2`.`id` = `monets_traffic`.`reciever_tp_id`')
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "orders") {
                $recordsTotal = Orders::find()->andWhere($query)->andWhere(['order_type' => $_GET['id']])->count();
                $recordsFiltered = Orders::find()->andWhere($condition)->andWhere(['order_type' => $_GET['id']])->andWhere($query)->andWhere($search_condition)->count();
                if(Yii::$app->session->get('profile_role') == 9){
                    $model = (new \yii\db\Query())
                        ->select('`orders`.`id`,
                         `users`.`name` as uname,
                         `users`.`phone`,
                         `orders`.`price`,
                         `orders`.`status`,
                         `taxi_park`.`name` as tname,
                         `orders`.`created`'
                        )
                        ->from($table)
                        ->where($query)
                        ->andWhere($condition)
                        ->andWhere(['order_type' => $_GET['id']])
                        ->innerJoin('users', 'users.id = orders.user_id')
                        ->innerJoin('taxi_park', 'taxi_park.id = orders.taxi_park_id')
                        ->limit($length)
                        ->offset($start)
                        ->all();
                }elseif (Yii::$app->session->get('profile_role') == 3){
                    $me = SystemUsers::findOne(['id' => Yii::$app->session->get('profile_id')]);
                    $my_cities = SystemUsersCities::find()->where(['system_user_id' => $me->id])->all();
                    $in = '';
                    foreach ($my_cities as $k => $v){
                        if($k == count($my_cities) - 1){
                            $in .= $v->city_id;
                        }else{
                            $in .= $v->city_id . ', ';
                        }
                        $cond = 'cities.id in (' . $in . ')';
                    }

                    $model = (new \yii\db\Query())
                        ->select('`orders`.`id`,
                         `users`.`name` as uname,
                         `users`.`phone`,
                         `orders`.`price`,
                         `orders`.`status`,
                         `taxi_park`.`name` as tname,
                         `orders`.`created`'
                        )
                        ->from($table)
                        ->where($query)
                        ->andWhere($condition)
                        ->andWhere(['order_type' => $_GET['id']])
                        ->innerJoin('users', 'users.id = orders.user_id')
                        ->innerJoin('taxi_park', 'taxi_park.id = orders.taxi_park_id')
                        ->innerJoin('cities', 'cities.id = users.city_id')
                        ->andWhere($cond)
                        ->limit($length)
                        ->offset($start)
                        ->all();
                }

            }
            else if ($name == "specific_orders") {
                $recordsTotal = SpecificOrders::find()->andWhere($query)->andWhere(['order_type_id' => $_GET['id']])->count();
                $recordsFiltered = SpecificOrders::find()->andWhere($condition)->andWhere(['order_type_id' => $_GET['id']])->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('`specific_orders`.`id`,
                         `users`.`name` as uname,
                         `users`.`phone`,
                         `specific_orders`.`price`,
                         `specific_orders`.`created`,
                         `start`.`cname` as a,
                         `end`.`cname` as b,
                         `specific_orders`.`from_string`,
                         `specific_orders`.`to_string`'
                    )
                    ->from($table)
                    ->where($query)
                    ->andWhere($condition)
                    ->andWhere(['order_type_id' => $_GET['id']])
                    ->leftJoin('users', 'users.id = specific_orders.driver_id')
                    ->innerJoin('cities as start', 'start.id = specific_orders.start_id')
                    ->innerJoin('cities as end', 'end.id = specific_orders.destination_id')
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "taxi_parks") {
                $recordsTotal = TaxiPark::find()->andWhere($query)->count();
                $recordsFiltered = TaxiPark::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('taxi_park.*, cities.cname as city '
                    )
                    ->from($table)
                    ->where($query)
                    ->andWhere($condition)
                    ->innerJoin('cities', 'cities.id = taxi_park.city_id')
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }

            else if ($name == "admins") {
                $sql = Queries::getSql($name);
                $recordsTotal = SystemUsers::find()->where(['role_id' => 3])->andWhere($query)->count();
                $recordsFiltered = SystemUsers::find()->where(['role_id' => 3])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);

                $model = $command->queryAll();

            }
            else if ($name == "tadmins") {
                $sql = Queries::getSql('tadmins');
                $recordsTotal = SystemUsers::find()->where(['role_id' => 5])->andWhere($query)->count();
                $recordsFiltered = SystemUsers::find()->where(['role_id' => 5])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);
                $model = $command->queryAll();

            }
            else if ($name == "companies") {
                $sql = Queries::getSql('companies');
                $recordsTotal = Company::find()->andWhere($query)->count();
                $recordsFiltered = Company::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);
                $model = $command->queryAll();

            }
            else if ($name == "cadmins") {
                $sql = Queries::getSql('cadmins');
                $recordsTotal = SystemUsers::find()->where(['role_id' => 7])->andWhere($query)->count();
                $recordsFiltered = SystemUsers::find()->where(['role_id' => 7])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);
                $model = $command->queryAll();

            }
            else if ($name == "moderators") {

                $sql = "SELECT su.id, su.first_name, su.last_name, su.last_edit, su.phone,
                               group_concat(distinct c.cname) as cities,
                               count(distinct driver.id)      as drivers,
                               count(distinct client.id)      as clients,
                               0 as sum
                        from system_users su
                               inner join system_users_cities suc on su.id = suc.system_user_id
                               inner join cities c on suc.city_id = c.id
                               left join users driver on driver.city_id = c.id and driver.role_id = 2
                               left join users client on client.city_id = c.id and client.role_id = 1
                        where su.role_id = 4
                        and c.id in  ( ". $_GET['ids'] ." )
                        group by su.id;";
                $recordsTotal = SystemUsers::find()->where(['role_id' => 4])->andWhere($query)->count();
                $recordsFiltered = SystemUsers::find()->where(['role_id' => 4])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);

                $model = $command->queryAll();

            }
            else if ($name == "stats-drivers") {
                $recordsTotal = Users::find()->where(['role_id' => 2])->andWhere($query)->count();
                $recordsFiltered = Users::find()->where(['role_id' => 2])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('users.id, genders.gender, users.name, users.rating, users.phone, users.created, users.balance, cities.cname as city, submodel.model submodel, car.number, model.model')
                    ->from('users')
                    ->innerJoin('cities', 'users.city_id = cities.id')
                    ->leftJoin('users_cars car', 'users.id = car.user_id')
                    ->leftJoin('car_models submodel', 'car.car_id = submodel.id')
                    ->innerJoin('car_models model', 'submodel.parent_id = model.id')
                    ->innerJoin('genders', 'users.gender_id = genders.id')
                    ->where($query)
                    ->andWhere(['users.role_id' => 2])
                    ->andWhere($condition)
                    ->limit($length)
                    ->offset($start)
                    ->groupBy(['users.id', 'car.id'])
                    ->all();
            }
            else if ($name == "driver_stat") {

                $sql = "select users.name,
                           users.id as id,
                           c.cname as city,
                           park.name as taxipark,
                           sum(case when monets_traffic.type_id = 5 or monets_traffic.type_id=6 then monets_traffic.amount else 0 end) as orders,
                           sum(case when monets_traffic.type_id = 4 then monets_traffic.amount else 0 end) as bonus_income,
                           sum(case when monets_traffic.type_id = 7 then monets_traffic.amount else 0 end) as kk,
                           sum(case when outcome.type_id = 2 or outcome.type_id = 3 then monets_traffic.amount else 0 end) as taxiplus,
                           sum(case when outcome.reciever_tp_id = users.taxi_park_id then monets_traffic.amount else 0 end) as taxipark_monets,
                           sum(case when outcome.type_id = 4 then outcome.amount else 0 end) as bonus,
                           sum(outcome.amount) as spent_money,
                           count(specific_orders.id) + count(orders.id) as orders_count,
                           IFNULL(sum(orders.price), 0)  as summa
                    from users
                      inner join taxi_park park on users.taxi_park_id = park.id
                      inner join cities c on users.city_id = c.id
                      left join monets_traffic on monets_traffic.reciever_user_id = users.id
                      left join monets_traffic outcome on outcome.sender_user_id = users.id
                      left join log_types on monets_traffic.type_id = log_types.id
                      left join orders on orders.driver_id = users.id
                      left join specific_orders on users.id = specific_orders.driver_id
                    where users.id = " . $_GET['id'] ."
                    group by users.id;";

                $recordsTotal = 1;
                $recordsFiltered = 1;
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand($sql);
                $model = $command->queryAll();

            }
            else if ($name == "referals") {
                $recordsTotal = Users::find()->andWhere($query)->count();
                $recordsFiltered = Users::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('parent.id, parent.phone, parent.name, count(child.id) referals, c.cname as city, sum(distinct mt.amount) as bonuses')
                    ->from('users child')
                    ->innerJoin('users parent', 'parent.id=child.parent_id')
                    ->innerJoin('cities c', 'parent.city_id = c.id')
                    ->leftJoin('monets_traffic mt', 'mt.reciever_user_id = parent.id')
                    ->andWhere(['mt.type_id' => 4])
                    ->limit($length)
                    ->offset($start)
                    ->groupBy('parent.id')
                    ->all();
            }

            else if ($name == "clients_stat") {
                $recordsTotal = Users::find()->andWhere($query)->count();
                $recordsFiltered = Users::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('users.id, users.name, users.phone, c.cname as city, users.created, count(distinct child.id) as referals, users.balance')
                    ->from('users')
                    ->leftJoin('users child', 'child.parent_id = users.id')
                    ->innerJoin('cities c', 'users.city_id = c.id')
                    ->where(['users.role_id' => 1])
                    ->limit($length)
                    ->offset($start)
                    ->groupBy('users.id')
                    ->all();
            }

            else if ($name == "stat_client") {
                $recordsTotal = Users::find()->andWhere($query)->count();
                $recordsFiltered = Users::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('users.id, count(o.id) as orders,
                                       sum(case when o.payment_type = 1 then 1 else 0 end ) as nal,
                                       sum(case when o.payment_type = 2 then 1 else 0 end ) as beznal,
                                       sum(case when o.payment_type = 3 then 1 else 0 end ) as bonus')
                    ->from('users')
                    ->innerJoin('orders o', 'o.user_id = users.id')
                    ->where(['users.id' => $_GET['id']])
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "taxi_park") {
                $recordsTotal = TaxiPark::find()->andWhere($query)->count();
                $recordsFiltered = TaxiPark::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('tp.*, c.cname as city,  (case when tp.type < 15 then 1 else 2 end) as typen')
                    ->from('taxi_park tp')
                    ->innerJoin('cities c', 'tp.city_id = c.id')
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "stat-tp") {
                $recordsTotal = TaxiPark::find()->andWhere($query)->count();
                $recordsFiltered = TaxiPark::find()->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('tp.*, c.cname as city,
                                       sum(case when tp.type < 15 and income.type_id = 2 then income.amount end)  as income_1,
                                       sum(case when tp.type < 15 and outcome.type_id = 1 then outcome.amount end)  as outcome_1,
                                       sum(case when tp.type > 14 and income.type_id = 2 then income.amount end)  as income_pay,
                                       sum(case when tp.type > 14 and income.type_id = 4 then income.amount end)  as income_bonus,
                                       sum(case when tp.type > 14 and income.type_id = 7 then income.amount end)  as income_kk,
                                       sum(case when tp.type > 14 and outcome.type_id = 2 then outcome.amount end) as outcome_tp,
                                       sum(case when tp.type > 14 and outcome.type_id = 4 then outcome.amount end) as outcome_bonus')
                    ->from('taxi_park tp')
                    ->innerJoin('cities c', 'tp.city_id = c.id')
                    ->innerJoin('monets_traffic income', ' tp.id = income.reciever_tp_id ')
                    ->innerJoin('monets_traffic outcome',  ' tp.id = outcome.sender_tp_id ')
                    ->where(['tp.id' => $_GET['id']])
                    ->limit($length)
                    ->offset($start)
                    ->all();
            }
            else if ($name == "stat_company") {
                $recordsTotal = Users::find()->where(['company_id' => $_GET['id']])->andWhere($query)->count();
                $recordsFiltered = Users::find()->where(['company_id' => $_GET['id']])->andWhere($condition)->andWhere($query)->andWhere($search_condition)->count();
                $model = (new \yii\db\Query())
                    ->select('u.name, u.id, u.phone, u.balance, sum(distinct m.amount) as monets')
                    ->from('users u')
                    ->leftJoin('monets_traffic m', 'u.id = m.sender_user_id')
                    ->where(['u.company_id' => $_GET['id']])
                    ->limit($length)
                    ->offset($start)
                    ->groupBy('u.id')
                    ->all();
            }


            $array['draw'] = $draw;
            $array['recordsTotal'] = $recordsTotal;
            $array['recordsFiltered'] = $recordsFiltered;
            $array['data'] = $model;

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $array;
        }
    }
}
?>
