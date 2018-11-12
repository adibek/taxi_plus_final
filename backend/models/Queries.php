<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/26/18
 * Time: 11:28 AM
 */
namespace backend\models;

class Queries{



    public static function getSql($key){
        $sql = ["moderators" => "SELECT su.id, su.first_name, su.last_name, su.last_edit, su.phone,
                                           group_concat(distinct c.cname) as cities,
                                           count(distinct driver.id)      as drivers,
                                           count(distinct client.id)      as clients
                                    from system_users su
                                           left join system_users_cities suc on su.id = suc.system_user_id
                                           left join cities c on suc.city_id = c.id
                                           left join users driver on driver.city_id = c.id
                                           left join users client on client.city_id = c.id
                                    where su.role_id = 4
                                    group by su.id;", "admins" => "SELECT su.id,
                                                                   su.first_name,
                                                                   su.last_name,
                                                                   su.last_edit,
                                                                   su.phone, 
                                                                   su.email,
                                                                   group_concat( distinct  c.cname) as cities,
                                                                   count(distinct driver.id) as drivers,
                                                                   count(distinct client.id) as clients,
                                                                   count(m.city_id) as moderators
                                                            from system_users su
                                                                    inner join system_users_cities suc on su.id = suc.system_user_id
                                                                    inner join cities c on suc.city_id = c.id
                                                                    left join users driver on driver.city_id = c.id and driver.role_id = 2
                                                                    left join users client on client.city_id = c.id and client.role_id = 1
                                                                    left join (select city.city_id
                                                                               from system_users moder
                                                                                  inner join system_users_cities city
                                                                                        on moder.id = city.system_user_id
                                                                               where moder.role_id = 4) m
                                                                     on m.city_id=suc.city_id
                                                            where su.role_id = 3
                        
                                                            group by su.id;", "tadmins" => "select su.*, park.name as park, count(distinct driver.id) as drivers, count(distinct clients.id) as clients, count(distinct u.id) as moderators, c.cname as city
                                                                                            from system_users su
                                                                                              inner join taxi_park park on su.taxi_park_id = park.id
                                                                                              left join users driver on park.id = driver.taxi_park_id and driver.role_id = 2
                                                                                              left join users clients on park.id = clients.taxi_park_id and clients.role_id = 1
                                                                                              left join system_users u on park.id = u.taxi_park_id and u.role_id = 4
                                                                                              inner join cities c on park.city_id = c.id
                                                                                            where su.role_id=5
                                                                                            group by su.id;", "companies" => "select c.*, u.first_name, u.last_name, c2.cname
from company c
left join system_users u on c.id = u.company_id and u.role_id = 7
inner join cities c2 on c.city_id = c2.id
group by c.id, u.id;", "cadmins" => "select admins.*, c.balance, c.name as company, c2.cname as city, count(distinct u.id) as clients
from system_users admins
inner join company c on admins.company_id = c.id
inner join cities c2 on c.city_id = c2.id
left join users u on c.id = u.company_id and u.role_id = 1
where admins.role_id=7
group by admins.id;"];

        return $sql[$key];
    }
}