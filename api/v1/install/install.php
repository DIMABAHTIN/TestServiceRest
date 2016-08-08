<?php
/**
 * Created by PhpStorm.
 * User: espe
 * Date: 06.08.2016
 * Time: 9:11
 */

require '../bootstrap.php';
require '../class/users_class.php';


$sql = file_get_contents('testservicedb(structure).sql');
$db->exec($sql);

$db->exec("START TRANSACTION;");

for($i=1; $i <= 10; $i++) {

    $r = rand(1,9999);

    // insert some data for table `merchants`
    $sql = "INSERT INTO `merchants` (name, description) VALUES ('name". $r . "', 'description". $r ."');";
    $db->exec($sql);

    // insert some data for table `users`
    $name = "name" . $r;
    $users = new users_class();
    $sql = "INSERT INTO `users` (name, email, password, token, datetime) VALUES ('". $name ."', 'email@email.com". $r ."','secret', '". $users->gen_token($name) ."', NOW());";
    $db->exec($sql);

    // insert some data for table `coupons`
    $sql = "INSERT INTO `coupons` (user_id, header, code) VALUES(". $i .", 'some header ". $r ."', '". $r.$r ."');";

    $db->exec($sql);
    $sql = "INSERT INTO `coupons` (merchant_id, header, code) VALUES(". $i .", 'some header ". $r ."', '". $r.$r ."');";
    $db->exec($sql);


}

$db->exec("COMMIT;");

echo 'install maybe complete';