<?php

  class MainObjective{
    public $id;
    public $name;
    public $finish_date;
    public $urgent;
    public $finished;
    public $users_id;

    public function setParams($name, $finish_date, $urgent, $users_id){
      $this->name = $name;
      $this->finish_date = $finish_date;
      $this->urgent = $urgent;
      $this->users_id = $users_id;
    }
  }

 ?>
