<?php
/**
 * Created by PhpStorm.
 * User: espe
 * Date: 05.08.2016
 * Time: 13:25
 */

class merchants_class {

    public function get_list () {
        global $db;
        $res = '';
        $sql = "SELECT m.`id`,m.`name`,m.`description`,c.`header`,c.code FROM `merchants` m "
            . "LEFT JOIN `coupons` c  ON (m.id=c.merchant_id) LIMIT 1000 ;";
        write_log($sql, 'merchants');
        try {
            $res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            write_log('$e', 'mysql_error');
        }
        return $res;
    }
    
    public function delete_merchant ($merchant_id) {
        global $db;
        $sql = "SELECT DISTINCT `id` FROM `merchants` WHERE `id`='". $merchant_id ."';";
        $res = $db->query($sql)->rowCount();
        if($res == 0) {
            return -1;
        }
        $sql = "UPDATE `coupons` SET `delete`=1 WHERE `merchant_id`='". $merchant_id ."';";
        $res_del_coupons = $db->exec($sql);
        
        $sql = "DELETE FROM `merchants` WHERE `id`='". $merchant_id ."';";
        $res_del_merchant = $db->exec($sql);
        if($res_del_merchant && $res_del_coupons) {
            return 1;
        } else {
            return 0;
        }
    }
    
    
    
    
}