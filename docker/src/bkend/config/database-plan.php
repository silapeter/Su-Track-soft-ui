<?php 
  class Database {
  // DB Params
  private $host = 'localhost';
  private $db_name = 'plan_db';
  private $username = 'plan';
  private $password = 'plan_su49';
  public $token = "cwVYDfrRbJg2mQPZ3rZjcSP3Kc5Tc";
  private $conn;



    // DB Connect
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn ->exec("set names utf8");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }