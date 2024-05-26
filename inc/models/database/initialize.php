<?php
    class Database{
       
    
        private $createStatements = [
            "CREATE TABLE IF NOT EXISTS Menu(   
                id INT AUTO_INCREMENT,
                course VARCHAR(15) NOT NULL,
                Name VARCHAR(30) NOT NULL,
                Description TEXT NOT NULL,
                price INT NOT NULL,
                allergens VARCHAR(100) NOT NULL,
                image_path VARCHAR(255),
                PRIMARY KEY(id)
            );",
            "CREATE TABLE IF NOT EXISTS Bills (
                bill_id INT PRIMARY KEY AUTO_INCREMENT,
                total_amount DECIMAL(10, 2),
                date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
                
            "CREATE TABLE IF NOT EXISTS Items (
                item_id INT PRIMARY KEY AUTO_INCREMENT,
                bill_id INT,
                item_name VARCHAR(255),
                quantity INT,
                unit_price DECIMAL(10, 2),
                FOREIGN KEY (bill_id) REFERENCES Bills(bill_id) ON DELETE CASCADE
            );",
            "CREATE TABLE IF NOT EXISTS employees(
                employee_id INT AUTO_INCREMENT,
                first_name VARCHAR(30) NOT NULL,
                last_name VARCHAR(30) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                birth_date DATE NOT NULL,
                hire_date DATE NOT NULL,
                position VARCHAR(50),
                department VARCHAR(50),
                salary DECIMAL(10, 2),
                password VARCHAR(255) NOT NULL,
                PRIMARY KEY (employee_id)
            );" 
        ];

        protected $pdo; 

        public function __construct(){
            // connect to database and configure PDO to throw and execption if errors occur 
            $host = 'localhost';
            $db = 'karenskitchen';
            $user = 'root';
            $password = '';
            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            try {
                $this->pdo = new PDO($dsn, $user, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            $this->init($this->pdo);
        }

        private function init($DB){
            try {
            if ($DB) {
                foreach ($this->createStatements as $statement) {
                    $DB->exec($statement);
                }
            }}
            catch (PDOException $e) {
                // Log the error or handle it appropriately
                error_log($e->getMessage());
                echo 'Table creation failed. Error: ' . $e->getMessage();
                die();
            }
        }

    }
?>

