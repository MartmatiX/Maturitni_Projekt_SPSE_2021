<?php

  class User{

    public $id;
    public $name;
    public $surname;
    public $username;
    public $password;
    public $email;
    public $permision;

    public function setParams($name, $surname, $username, $password, $email){
      $this->name = $name;
      $this->surname = $surname;
      $this->username = $username;
      $this->password = $password;
      $this->email = $email;
    }

  }

 ?>
