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
    $goals1 = rand(0, 3);
    $goals2 = rand(0, 3);

    if(rand(0, 10) == 9) $goals1 += rand(1, 5);
    if(rand(0, 10) ==9) $goals2 += rand(1, 5);

    $this->score1 = $goals1;
    $this->score2 = $goals2;

    $this->updateTeamData();
  }

  private function updateTeamData() {
    $this->team1->addGoals($this->score1);
    $this->team2->addGoals($this->score2);
    $this->team1->addScored($this->score2);
    $this->team2->addScored($this->score1);

    if($this->score1 == $this->score2) {
      $this->team1->addScore(1);
      $this->team2->addScore(1);
    } else if($this->score1 > $this->score2) {
      $this->team1->addScore(3);
    } else {
      $this->team2->addScore(3);
    }
  }

  public function getWinner() {
    if($this->score1 == $this->score2) return null;
    if($this->score1 > $this->score2) return $this->team1;
    if($this->score1 < $this->score2) return $this->team2;
  }

  public function getTeam1Score() {
    if($this->score1 == $this->score2) return 1;
    if($this->score1 > $this->score2) return 3;
    if($this->score1 < $this->score2) return 0;
  }
  public function getTeam2Score() {
    if($this->score1 == $this->score2) return 1;
    if($this->score1 > $this->score2) return 0;
    if($this->score1 < $this->score2) return 3;
  }
}

?>