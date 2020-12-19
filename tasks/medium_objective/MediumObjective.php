<?php

  class MediumObjective{
    public $id;
    public $name;
    public $finish_date;
    public $finished;
    public $main_objectives_id;

    public function setParams($name, $finish_date){
      $this->name = $name;
      $this->finish_date = $finish_date;
    }
  }

 ?>
