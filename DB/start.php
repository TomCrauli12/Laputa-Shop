<?php

class DB{

    static function getConnection(){

        $host = 'localhost';
        $dbname = 'laputa';
        $user = 'root';
        $password = 'root';

        if (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['DOCUMENT_ROOT'], '/Applications/MAMP/htdocs') === 0) {
            $password = 'root';
        }

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

        !$conn ? die("DB_ERROR") : 0;
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;

    }

}

?>