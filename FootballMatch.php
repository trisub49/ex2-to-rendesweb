<?php


class FootballMatch {
  
  private $team1;
  private $team2;
  private $score1;
  private $score2;

  function __construct($team1, $team2) {
    $this->team1 = $team1;
    $this->team2 = $team2;
    $this->doMatch($team1, $team2);
  }

  public function getTeam1() {
    return $this->team1;
  }
  public function getTeam2() {
    return $this->team2;
  }
  public function getScore1() {
    return $this->score1;
  }
  public function getScore2() {
    return $this->score2;
  }

  private function doMatch($team1, $team2) {
    $goals1 = rand(0, 10);
    $goals2 = rand(0, 10);

    if($goals1 > 5 && rand(0, 10) < 10) $goals1 -= rand(1, 5);
    if($goals2 > 5 && rand(0, 10) < 10) $goals2 -= rand(1, 5);

    $this->score1 = $goals1;
    $this->score2 = $goals2;
  }

  public function getWinner() {
    $this->team1->setScores($this->team1->getScores() + $this->score1);
    $this->team2->setScores($this->team2->getScores() + $this->score2);

    if($this->team1->getScores() == $this->team2->getScores()) return null;
    if($this->team1->getScores() > $this->team2->getScores()) return $this->team1;
    if($this->team1->getScores() < $this->team2->getScores()) return $this->team2;
  }
}

?>