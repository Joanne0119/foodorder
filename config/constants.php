<?php
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '2021athome');
    define('DB_NAME', 'food_order');


    // 建立資料庫連線
    function getDbConnection() {
        $conn = new mysqli(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // 檢查連線是否成功
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
?>