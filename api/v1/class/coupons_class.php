<?php

/**
 * Created by PhpStorm.
 * User: espe
 * Date: 05.08.2016
 * Time: 14:00
 */
class coupons_class {

    public function get_coupons_merchant ($merchant_id) {
        global $db;
        $sql = "SELECT `id`,`header`,`code` FROM `coupons` WHERE `merchant_id`='". $merchant_id ."' AND `delete`!=1";
        $res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function get_coupons_user ($user_id) {
        global $db;
        $sql = "SELECT `id`,`header`,`code` FROM `coupons` WHERE `user_id`='". $user_id ."'";
        $res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

}