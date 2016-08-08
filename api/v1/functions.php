<?php
/**
 * Created by PhpStorm.
 * User: espe
 * Date: 03.08.2016
 * Time: 23:17
 */

// function of logging
function write_log ($log, $prefix='')
{

    if (DEBUG == 1) {

        if ($prefix != '') {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/api/v1/logs/' . $prefix . '_' . date('d-m-Y') . '.log';
        } else {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/api/v1/logs/' . date('d-m-Y') . '.log';
        }

        file_put_contents($file, date('H:i:s') . ' ' . $log . "\r\n", FILE_APPEND);
    }
}

