<?php
    class Database{
       

        private $createStatements = [

            //Table for Courses
            "CREATE TABLE Course (
                courseId VARCHAR(255) PRIMARY KEY,
                courseName VARCHAR(255) NOT NULL,
                description TEXT
            );",
            
            //Table for AssessmentStructures
            "CREATE TABLE AssessmentStructure (
                assessmentId VARCHAR(255) PRIMARY KEY,
                courseId VARCHAR(255),
                assessmentName VARCHAR(255) NOT NULL,
                FOREIGN KEY (courseId) REFERENCES Course(courseId)
            );",
            
            //Table for Sections
            "CREATE TABLE Section (
                sectionId VARCHAR(255) PRIMARY KEY,
                assessmentId VARCHAR(255),
                sectionName VARCHAR(255) NOT NULL,
                maxScore DOUBLE,
                FOREIGN KEY (assessmentId) REFERENCES AssessmentStructure(assessmentId)
            );",
            
            //Table for GroupContributionReports
            "CREATE TABLE GroupContributionReport (
                reportId VARCHAR(255) PRIMARY KEY,
                groupId VARCHAR(255) NOT NULL,
                members TEXT  -- List of Member IDs as JSON or another suitable format
            );",
            
            //Table for Members
            "CREATE TABLE Member (
                memberId VARCHAR(255) PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                groupId VARCHAR(255),
                contributionPercent DOUBLE
            );",
            
            // Table for Scores
            "CREATE TABLE Score (
                scoreId VARCHAR(255) PRIMARY KEY,
                memberId VARCHAR(255),
                sectionId VARCHAR(255),
                scoreValue DOUBLE,
                FOREIGN KEY (memberId) REFERENCES Member(memberId),
                FOREIGN KEY (sectionId) REFERENCES Section(sectionId)
            );",
            
            //Table for Comments
            "CREATE TABLE Comment (
                commentId VARCHAR(255) PRIMARY KEY,
                memberId VARCHAR(255),
                content TEXT,
                FOREIGN KEY (memberId) REFERENCES Member(memberId)
            );",
            
            //Table for CourseMember (many-to-many relationship between Course and Member)
            "CREATE TABLE CourseMember (
                memberId VARCHAR(255),
                courseId VARCHAR(255),
                PRIMARY KEY (memberId, courseId),
                FOREIGN KEY (memberId) REFERENCES Member(memberId),
                FOREIGN KEY (courseId) REFERENCES Course(courseId)
            );",
            
        ];

        protected $pdo; 

        public function __construct(){
            // connect to database and configure PDO to throw and execption if errors occur 
            $host = 'localhost';
            $db = 'dcs_grades';
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

