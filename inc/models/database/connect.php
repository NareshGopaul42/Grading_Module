<?php 

    function connect() {
        $host = 'localhost';
        $db = 'dcs_grades';
        $user = 'root';
        $password = '';

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        // connect to database and configure PDO to throw and execption if errors occur
        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }

    return connect();

?>
