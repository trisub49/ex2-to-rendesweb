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
      echo '<b>( '.$this->getName().' ) csoport mérkőzések: </b> <br>';
      $matchCounter = 0;
      $actualTeam = 0;
      for($i = 0; $i < count($this->teams); $i ++) {
        $opponent = $this->getAnOpponent($this->teams[$i]);
        if($opponent != null) {
          $match = new FootballMatch($this->teams[$i], $opponent);
          $match->getWinner();
          array_push($this->matches, $match);
          echo $this->teams[$i]->getCountry().' vs '.$opponent->getCountry().'  ('.$match->getScore1().'-'.$match->getScore2().') <br>';
          
          $matchCounter ++;
          if($i == count($this->teams) - 1) $i = -1;
          if($matchCounter == 6) break;
        }
      }

      echo '<b>Továbbjutó: '.$this->getWinner()->getCountry().' '.$this->getWinner()->getScores().' ponttal. </b> <hr><br>';
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

    private function isInMatches($team1, $team2) {
      for($i = 0; $i < count($this->matches); $i ++) {
        if(($this->matches[$i]->getTeam1()->getCountry() == $team1->getCountry() && $this->matches[$i]->getTeam2()->getCountry() == $team2->getCountry()) ||
          ($this->matches[$i]->getTeam2()->getCountry() == $team1->getCountry() && $this->matches[$i]->getTeam1()->getCountry() == $team2->getCountry())) 
           return true;
      }
      return false;
    }

    public function getWinner() {
      $maxScoreId = 0;
      for($i = 1; $i < count($this->teams); $i ++) {
        if($this->teams[$i]->getScores() > $this->teams[$maxScoreId]->getScores()) {
          $maxScoreId = $i;
        }
      }
      return $this->teams[$maxScoreId];
    }
  }
?>