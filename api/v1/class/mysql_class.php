<?php

/**
 * Created by PhpStorm.
 * User: espe
 * Date: 21.05.2016
 * Time: 14:37
 */
class mysql_class {

    var $db;
    var $stmt;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=" . MYSQL_SERVER . ";dbname=" . MYSQL_DB, MYSQL_USER, MYSQL_PASSWORD);
        } catch (PDOException $e) {
            echo 'Cannot connect to MySQL. Check config.php';
            write_log($e->getMessage(), 'MYSQL_CONNECT');
        }
        return $this->db;
    }

    public function query($query) {
        try {
            $this->stmt = $this->db->query($query);
        } catch (PDOException $e) {
            write_log($e, 'mysql_error');
        }
        return $this->stmt;
    }

    public function exec($query) {
        try {
            $this->stmt = $this->db->exec($query);
        } catch (PDOException $e) {
            write_log($e, 'mysql_error');
        }
        return $this->stmt;
    }








}