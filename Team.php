<?php

class Team {

  private $name;
  private $country;
  private $score;
  private $goals;
  private $scored;
  private $draw;

  function __construct($name, $country) {
    $this->name = $name;
    $this->country = $country;
    $this->score = 0;
    $this->goals = 0;
    $this->scored = 0;
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

  public function getScore() {
    return $this->score;
  }
  public function addScore($score) {
    $this->score += $score;
  }

  public function getScored() {
    return $this->scored;
  }
  public function addScored($scored) {
    $this->scored += $scored;
  }
  
  public function getGoals() {
    return $this->goals;
  }
  public function addGoals($goals) {
    $this->goals += $goals;
  }
}

?>