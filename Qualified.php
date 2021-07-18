<?php

class Qualified {
  private $team;
  private $isQualified;
  private $isRaised;

  function __construct($team, $isQualified, $isRaised) {
    $this->team = $team;
    $this->isQualified = $isQualified;
    $this->isRaised = $isRaised;
  }

  public function isRaised() {
    return $this->isRaised;
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