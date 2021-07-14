<?php

class Qualified {
  private $team;
  private $isQualified;

  function __construct($team, $isQualified) {
    $this->team = $team;
    $this->isQualified = $isQualified;
  }

  public function isQualified() {
    return $this->isQualified;
  }

  public function setQualified($bool) {
    $this->isQualified = $bool;
  }

  public function getTeam() {
    return $this->team;
  }
}

?>