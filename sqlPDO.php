<?php 

// Připojovací údaje
define('SQL_HOST', 'xxx');
define('SQL_DBNAME', 'xxx');
define('SQL_USERNAME', 'xxx');
define('SQL_PASSWORD', 'xxx');

class sqlPDO {
  function __construct() {
    $this->dsn = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . ';chaset=utf8';
    $this->user = SQL_USERNAME;
    $this->password = SQL_PASSWORD;

    try {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("set names utf8");
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
  }
}
