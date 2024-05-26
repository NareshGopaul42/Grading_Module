
<?php
    
    include_once __DIR__."/../models/database/initialize.php";
    class initController{
        //private $base_cart;

        public function __construct(){
            
        }

        public function home(){
            include_once __DIR__."/../view/assessmentManagement.php";
        }
        public function courses(){
            include_once __DIR__."/../view/courses.php";
        }

     

    }
?>