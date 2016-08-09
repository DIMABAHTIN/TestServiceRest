<?php
/**
 * Created by PhpStorm.
 * User: espe
 * Date: 03.08.2016
 * Time: 23:02
 */

require 'bootstrap.php';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$input = file_get_contents('php://input');

$action = $request[2];
$data = $request[3];

// action users
if($action == 'users') {
    require 'class/users_class.php';
    $user = new users_class();
 
    switch ($method) {
        // get list of all users (json)
        case 'GET':
            if ($data == '' || $data == 'all') {
                //get data of all user (limit 1000)
                $res = $user->get_list();
            } else {
                $res = $user->get_user($data);
            }
                if ($res != '') {
                    write_log(print_r($res,TRUE),'get');
                    http_response_code(200);
                    echo json_encode($res);
                } else {
                    http_response_code(404);
                }
            break;

    // add new user
        case 'POST':
            if($data == '') {
                write_log($input, 'new_user');
                    if ($user->add_user($input) > 0) {
                        http_response_code(201);
                    } else {
                        http_response_code(409);
                    }
            } else {
                http_response_code(405);
            }
            break;

        //delete user by id
        case 'DELETE':
            if($data != '') {
                if($user->delete_user($data)) {
                    http_response_code(202);
                } else {
                    http_response_code(404);
                }
            }
        break;
        
        case 'PUT':
            
            if($data != '') {
                write_log($input . $data, 'put');
                $res = $user->update_user($data, $input);
                if($res > 0) {
                    http_response_code(201);
                } elseif($res == -1) {
                    http_response_code(404);
                } else {
                    http_response_code(500);
                }
            }
        break;
        default:
            http_response_code(405);
}

/* CASE MERCHANTS */
} elseif($action == 'merchants') {
    require 'class/merchants_class.php';
    $merchant = new merchants_class();

    switch ($method) {
        // get list of all merchants (json)
        case 'GET':
            if ($data == '' || $data == 'all') {
                //get data of all merchants (limit 1000)
                $res = $merchant->get_list();

                if ($res != '') {
                    write_log(print_r($res, TRUE), 'get');
                    http_response_code(200);
                    echo json_encode($res);
                } else {
                    http_response_code(404);
                }
            }
            break;

        //delete user by id
        case 'DELETE':
            if ((int)$data != '') {
                if ($merchant->delete_merchant($data) > 0) {
                    http_response_code(202);
                } else {
                    http_response_code(404);
                }
            }
            break;
        
        default:
            http_response_code(405);
            }

} elseif($action == 'coupons') {
    require 'class/coupons_class.php';
    $coupons = new coupons_class();

    switch ($method) {
        // get list of all merchants coupons (json)
        case 'GET':
            //get data of all merchants coupons (limit 1000)
            if($data != '') {
                $res = $coupons->get_coupons_merchant((int)$data);

                if ($res != '') {
                    write_log(print_r($res, TRUE), 'get');
                    http_response_code(200);
                    echo json_encode($res);
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(405);
            }

            break;

        case 'POST':
            //get data of all users coupons 
            if($data != '') {
                $res = $coupons->get_coupons_user((int)$data);

                if ($res != '') {
                    write_log(print_r($res, TRUE), 'get');
                    http_response_code(200);
                    echo json_encode($res);
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(405);
            }

            break;

        default:
            http_response_code(405);
    }
}
