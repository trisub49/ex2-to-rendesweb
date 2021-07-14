<?php

class Team {

  private $name;
  private $country;
  private $scores;

  function __construct($name, $country, $scores) {
    $this->name = $name;
    $this->country = $country;
    $this->scores = $scores;
  }

  public function getName() {
    return $this->name;
  }
  public function setName($name) {
    $this->name = $name;
  }

  public function getCountry() {
    return $this->country;
  }
  public function setCountry($country) {
    $this->country = $country;
  }

  public function getScores() {
    return $this->scores;
  }
  public function setScores($scores) {
    $this->scores = $scores;
  }

}

?>