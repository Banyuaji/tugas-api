<?php
    class dataObj {
    var $host = 'localhost';
    var $user = 'root';
    var $pw = '';
    var $db = 'php_api';
    var $conn;
    function getConnString() {
        $con = mysqli_connect($this->host,
        $this->user,
        $this->pw,
        $this->db) or
        die("Connection failed: ". mysqli_connect_error());
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } else {
            $this->conn = $con;
        }
        return $this->conn;
    }
}
?>