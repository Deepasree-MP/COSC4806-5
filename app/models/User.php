<?php

require_once 'app/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }
  
    public function get_all_users()
    {
        $statement = $this->db->prepare("SELECT * FROM users;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create_user($username, $password)
    {
        if ($this->user_exists($username)) {
            throw new Exception("Username already exists.");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->db->prepare(
            "INSERT INTO users (username, password) VALUES (:username, :password)"
        );
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $hashed_password);
        $statement->execute();

        return $this->db->lastInsertId();
    }

    public function user_exists($username)
    {
        $statement = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();
        return $statement->rowCount() > 0;
    }
  
    public function get_user_by_username($username)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = :username LIMIT 1"
        );
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


  public function authenticate($username, $password)
  {
      $username = strtolower($username);
      $statement = $this->db->prepare("SELECT * FROM users WHERE username = :name");
      $statement->bindValue(':name', $username);
      $statement->execute();
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($password, $user['password'])) {
          return $user;
      }
      return false;
  }
}
