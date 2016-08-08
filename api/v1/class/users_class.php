<?php

/**
 * Created by PhpStorm.
 * User: espe
 * Date: 05.08.2016
 * Time: 13:25
 */
class users_class
{

    /**
     * Generate token of user
     * return string token
     */
    public function gen_token($user_name) {
        return md5($user_name . "some_symbols");
    }

    /**
     * @param $json
     * @param string users_class name
     * @param string users_class email
     * @param string users_class password
     * @return int
     */
    public function add_user ($json) {
        global $db;
        $name = $email = $password = '';
        $user_array = json_decode($json, TRUE);
        $user_array = array_map('addslashes', $user_array);
        extract($user_array);

        $sql = "INSERT INTO `users` (name, email, password, token, datetime) 
        VALUES ('". $name ."', '". $email ."', '". $password ."', '". $this->gen_token($name) ."', NOW())";
        write_log($sql);
        $res = $db->exec($sql);
        return $res;


    }

    public function get_list() {
        global $db;
        $sql = "SELECT `id`,`name`,`email`,`datetime` FROM `users` LIMIT 1000";
        $res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        write_log($res);
        return $res;
    }


    public function get_user($token) {
        global $db;
        $token = addslashes($token);
        $sql = "SELECT `id`,`name`,`email`,`datetime` FROM `users` WHERE `token` LIKE '%". $token ."%'";
        $res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        write_log($res);
        return $res;
    }

    public function update_user($token, $json) {
        global $db;
        $name = $email = $password = '';
        $user_array = json_decode($json, TRUE);
        $user_array = array_map('addslashes', $user_array);
        extract($user_array);

        $sql = "UPDATE `users` SET `name`='". $name ."',`email`='". $email ."',`password`='". $password ."' WHERE `token`='" .$token. "';";
        write_log($sql);
        $res = $db->exec($sql);
        return $res;
    }

    public function delete_user($token) {
        global $db;
        $token = addslashes($token);
        $sql = "SELECT DISTINCT `id` FROM `users` WHERE `token` = '". $token ."';";
        $res = $db->query($sql)->rowCount();
        if($res == 0) {
            return -1;
        }
        $sql = "DELETE FROM `users` WHERE `token`='" .$token. "';";
        write_log($sql);
        $res = $db->exec($sql);
        return $res;
    }


}