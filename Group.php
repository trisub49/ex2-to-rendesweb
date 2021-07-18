<?php
  require('FootballMatch.php');

  class Group {
    private $teams = array();
    private $name;
    private $matches = array();

    function __construct($name) {
      $this->name = $name;
    }

    public function getName() {
      return $this->name;
    }
    public function setName($name) {
      $this->name = $name;
    }

    public function addTeam($team) {
      array_push($this->teams, $team);
    }
    public function removeTeam($team) {
      if(($team = array_search($team, $this.teams, true)) !== FALSE) {
        unset($this->teams[$team]);
      }
      return $this->teams;
    }

    public function doGroupMatch() {
      $matchCounter = 0;
      $actualTeam = 0;
      
      for($i = 0; $i < count($this->teams); $i ++) {
        $opponent = $this->getAnOpponent($this->teams[$i]);
        if($opponent != null) {
          $match = new FootballMatch($this->teams[$i], $opponent);
          $match->getWinner();
          array_push($this->matches, $match);
          $matchCounter ++;
          if($i == count($this->teams) - 1) $i = -1;
          if($matchCounter == 6) break;
        }
      }
    }

    public function showMatches() {
      echo 
      '
        <div class="col-4 float-left">
        <b>( '.$this->getName().' ) csoport mérkőzések: </b> <br>
        <table class="table table-striped table-sm">
        <tr class="font-weight-bold">
        <td>Pont</td><td>Csapat 1</td> <td>Gólok</td> <td>Csapat 2</td><td>Pont</td>
        </tr>
      ';
      for($i = 0; $i < count($this->matches); $i ++) {
        echo 
        '
          <tr>
          <td>+'.$this->matches[$i]->getTeam1Score().'</td>
          <td>'.$this->matches[$i]->getTeam1()->getCountry().'</td>
          <td>('.$this->matches[$i]->getScore1().'-'.$this->matches[$i]->getScore2().')</td>
          <td>'.$this->matches[$i]->getTeam2()->getCountry().'</td>
          <td>+'.$this->matches[$i]->getTeam2Score().'</td>
          </tr>
        ';
      }
      echo '</table></div>';
    }

    public function getWinners() {
      $winners = array();
      $array = $this->teams;
      $maxScoreId = 0;

      for($x = 0; $x < 3; $x ++) {
        for($i = 1; $i < count($array); $i ++) {
          if($array[$i]->getScore() > $array[$maxScoreId]->getScore()) {
            $maxScoreId = $i;
          } else if($array[$i]->getScore() == $array[$maxScoreId]->getScore()) {
            if($array[$i]->getGoals() > $array[$maxScoreId]->getGoals()) {
              $maxScoreId = $i;
            } else if($array[$i]->getGoals() == $array[$maxScoreId]->getGoals()) {
              if($array[$i]->getScored() < $array[$maxScoreId]->getScored()) {
                $maxScoreId = $i;
              }
            }
          }
        }
        array_push($winners, $array[$maxScoreId]);
        unset($array[$maxScoreId]);
        $array = array_values($array);
        $maxScoreId = 0;
      }
      return $winners;
    }
    
    public function showSummary() {
      echo '<div class="col-4"><b>Összesítés: </b><br>';
      echo '<table class="table table-dark table-striped"> 
      <tr class="font-weight-bold">
      <td>Ország</td><td>Gól</td><td>Kapott gól</td><td>Pontszám</td>
      </tr>';
      for($i = 0; $i < count($this->teams); $i ++) {
        echo 
        '
        <tr>
        <td>'.$this->teams[$i]->getCountry().'</td>
        <td>'.$this->teams[$i]->getGoals().'</td>
            <td>'.$this->teams[$i]->getScored().'</td>
            <td>'.$this->teams[$i]->getScore().'</td>
          </tr>
          ';
      }
      echo '</table></div>';
    }

    public function showQualified($thirdQualified) {
      echo '<div class="col-4 float left"><b>Továbbjutók:</b><br>';
      $winners = $this->getWinners();
      for($i = 0; $i < ($thirdQualified ? 3 : 2); $i ++) {
        echo '<span class="h3">'.$winners[$i]->getCountry().' '.$winners[$i]->getScore().' ponttal. </span><br>';
      }
      echo '</div>';
    }

    private function isInMatches($team1, $team2) {
      for($i = 0; $i < count($this->matches); $i ++) {
        if(($this->matches[$i]->getTeam1()->getCountry() == $team1->getCountry() && $this->matches[$i]->getTeam2()->getCountry() == $team2->getCountry()) ||
          ($this->matches[$i]->getTeam2()->getCountry() == $team1->getCountry() && $this->matches[$i]->getTeam1()->getCountry() == $team2->getCountry())) 
           return true;
          }
          return false;
    }

    private function getAnOpponent($team) {
      for($i = 0; $i < count($this->teams); $i ++) {
        if($team != $this->teams[$i]) {
          if(!count($this->matches)) return $this->teams[$i];
          if(!$this->isInMatches($team, $this->teams[$i])) {
            return $this->teams[$i];
          } 
        }
      }
      return null;
    }
  }
?>