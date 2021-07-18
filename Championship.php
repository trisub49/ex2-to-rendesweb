<?php

  require('Team.php');
  require('Group.php');
  require('Qualified.php');

  class Championship {

    public $group_a;
    public $group_b;
    public $group_c;
    public $group_d;
    public $group_e;
    public $group_f;

    public $groups = array();
    public $qualifieds = array();

    public function initGroups() {
      $this->group_a = new Group('A');
      $this->group_a->addTeam(new Team("?", "Olaszország", 0));
      $this->group_a->addTeam(new Team("?", "Wales", 0));
      $this->group_a->addTeam(new Team("?", "Svájc", 0));
      $this->group_a->addTeam(new Team("?", "Törökország", 0));
      $this->group_b = new Group('B');
      $this->group_b->addTeam(new Team("?", "Belgium", 0));
      $this->group_b->addTeam(new Team("?", "Dánia", 0));
      $this->group_b->addTeam(new Team("?", "Finnország", 0));
      $this->group_b->addTeam(new Team("?", "Oroszország", 0));
      $this->group_c = new Group('C');
      $this->group_c->addTeam(new Team("?", "Hollandia", 0));
      $this->group_c->addTeam(new Team("?", "Ausztria", 0));
      $this->group_c->addTeam(new Team("?", "Ukrajna", 0));
      $this->group_c->addTeam(new Team("?", "Észak-Macedónia", 0));
      $this->group_d = new Group('D');
      $this->group_d->addTeam(new Team("?", "Anglia", 0));
      $this->group_d->addTeam(new Team("?", "Horvátország", 0));
      $this->group_d->addTeam(new Team("?", "Cseh köztársaság", 0));
      $this->group_d->addTeam(new Team("?", "Skócia", 0));
      $this->group_e = new Group('E');
      $this->group_e->addTeam(new Team("?", "Svédország", 0));
      $this->group_e->addTeam(new Team("?", "Spanyolország", 0));
      $this->group_e->addTeam(new Team("?", "Szlovákia", 0));
      $this->group_e->addTeam(new Team("?", "Lengyelország", 0));
      $this->group_f = new Group('F');
      $this->group_f->addTeam(new Team("?", "Franciaország", 0));
      $this->group_f->addTeam(new Team("?", "Németország", 0));
      $this->group_f->addTeam(new Team("?", "Portugália", 0));
      $this->group_f->addTeam(new Team("?", "Magyarország", 0));
      array_push($this->groups, 
        $this->group_a,
        $this->group_b,
        $this->group_c,
        $this->group_d,
        $this->group_e,
        $this->group_f
      );
    }

    public function doAllGroupMatch() {

      $thirdTeams = array();
      for($i = 0; $i < count($this->groups); $i ++) {
        $this->groups[$i]->doGroupMatch();
        $winners = $this->groups[$i]->getWinners();
        array_push($this->qualifieds, 
          new Qualified($winners[0], true, true),
          new Qualified($winners[1], true, false)
        );
        array_push($thirdTeams, $winners[2]);
      }
      
      $bestFour = $this->getBestFourFromThirds($thirdTeams);
      for($i = 0; $i < count($bestFour); $i ++) {
        array_push($this->qualifieds, new Qualified($bestFour[$i], true, false));
      }

     
      for($i = 0; $i < count($this->groups); $i ++) {
        echo '<div class="col-12 d-flex flex-row m-3">';
        $this->groups[$i]->showMatches();
        $this->groups[$i]->showSummary();
        if(in_array($this->groups[$i]->getWinners()[2], $bestFour)) {
          $this->groups[$i]->showQualified(true);
        } else {
          $this->groups[$i]->showQualified(false);
        }
        echo '</div>';
      }
    }

    public function doAllQualifiedMatch() {
      $count = 0;
      for($x = 0; $x < 3; $x ++) {

        echo '<div class="col-12 float-left m-3 d-flex flex-row">';
        echo '<div class="col-4">';
        if($x == 0) echo '<b>Nyolcaddöntők: </b>';
        else if($x == 1) echo '<b>Negyeddöntők: </b>';
        else if($x == 2) echo '<b>Elődöntők: </b>';
        echo 
        '
          <table class="table table-striped table-sm">
            <tr class="font-weight-bold">
              <td>Pont</td><td>Csapat 1</td> <td>Gólok</td> <td>Csapat 2</td><td>Pont</td>
            </tr>
        ';
        for($i = 0; $i < count($this->qualifieds); $i = $i+2) {
          if($i < count($this->qualifieds) - 1 && count($this->qualifieds) > 2) {
            $opponent = $i + 1;
            
            $match = new FootballMatch($this->qualifieds[$i]->getTeam(), $this->qualifieds[$opponent]->getTeam());
            echo 
            '
              <tr>
                <td>+'.$match->getTeam1Score().'</td>
                <td>'.$match->getTeam1()->getCountry().'</td>
                <td>('.$match->getScore1().'-'.$match->getScore2().')</td>
                <td>'.$match->getTeam2()->getCountry().'</td>
                <td>+'.$match->getTeam2Score().'</td>
              </tr>
            ';
            if($match->getWinner() == null) {
              $winner = rand(0, 1);
              if($winner == 0) {
                $this->qualifieds[$i]->setQualified(true);
                $this->qualifieds[$opponent]->setQualified(false);
              } else {
                $this->qualifieds[$i]->setQualified(false);
                $this->qualifieds[$opponent]->setQualified(true);
              }
              echo 
              '
                <tr>
                  <td colspan="5" class="text-success">A tizenegyes párbajban '.$this->qualifieds[$i + $winner]->getTeam()->getCountry().' nyert.</td>
                </tr>
              ';
            } else {
              if($match->getWinner()->getCountry() == $this->qualifieds[$i]->getTeam()->getCountry()) {
                $this->qualifieds[$i]->setQualified(true);
                $this->qualifieds[$opponent]->setQualified(false);
              } else {
                $this->qualifieds[$i]->setQualified(false);
                $this->qualifieds[$opponent]->setQualified(true);
              }
            }
          }
        }
        echo '</table> </div>';
        $this->showSummary();
        $this->removeUnQualifiedTeams();
        echo '</div>';
      }
      $this->doFinal();
      
    }

    private function showSummary() {
      echo '<div class="col-4 float right"><b>Összesítés: </b><br>';
        echo 
        '
          <table class="table table-dark table-striped table-sm"> 
          <tr class="font-weight-bold">
          <td>Ország</td><td>Gól</td><td>Kapott gól</td><td>Pontszám</td>
          </tr>
        ';
        for($i = 0; $i < count($this->qualifieds); $i ++) {
          echo 
          '
            <tr>
              <td>'.$this->qualifieds[$i]->getTeam()->getCountry().'</td>
              <td>'.$this->qualifieds[$i]->getTeam()->getGoals().'</td>
              <td>'.$this->qualifieds[$i]->getTeam()->getScored().'</td>
              <td>'.$this->qualifieds[$i]->getTeam()->getScore().'</td>
            </tr>
          ';
        }
        echo '</table></div>';
    }

    private function doFinal() {
      $match = new FootballMatch($this->qualifieds[0]->getTeam(), $this->qualifieds[1]->getTeam());
      echo 
      '
        <div class="col-12 float-left p-3"><b>Döntő</b>: 
          <table class="table table-striped table-dark">
            <tr class="font-weight-bold">
              <td>Pont</td><td>Csapat 1</td> <td>Gólok</td> <td>Csapat 2</td><td>Pont</td>
            </tr>
            <tr>
              <td>+'.$match->getTeam1Score().'</td>
              <td>'.$match->getTeam1()->getCountry().'</td>
              <td>('.$match->getScore1().'-'.$match->getScore2().')</td>
              <td>'.$match->getTeam2()->getCountry().'</td>
              <td>+'.$match->getTeam2Score().'</td>
            </tr>
      ';
      if($match->getWinner() == null) {
        $winner = rand(0, 1);
        echo '<tr>';
        if($winner == 0) {
          echo '<td colspan="5" class="text-success">A tizenegyes párbajban '.$match->getTeam1()->getCountry().' nyert.</td>';
        } else {
          echo '<td colspan="5" class="text-success">A tizenegyes párbajban '.$match->getTeam2()->getCountry().' nyert.</td>';
        }  
        echo '</tr>';
      }
      echo '</table>';
    }

    private function removeUnQualifiedTeams() {
      $newQualifieds = array();
      echo '<div class="col-6"><b>Kiesők</b><br>';
      for($i = 0; $i < count($this->qualifieds); $i ++) {
        if($this->qualifieds[$i]->isQualified()) {
          array_push($newQualifieds, new Qualified($this->qualifieds[$i]->getTeam(), true, false));
        } else {
          echo '<span class="h3">'.$this->qualifieds[$i]->getTeam()->getCountry().'</span><br>';
        }
      }
      echo '</div>';
      $this->qualifieds = array();
      $this->qualifieds = $newQualifieds;
    }

    private function getBestFourFromThirds($thirdTeams) {
      $bestFour = array();
      $maxScoreId = 0;

      for($x = 0; $x < 4; $x ++) {
        for($i = 1; $i < count($thirdTeams); $i ++) {
          if($thirdTeams[$i]->getScore() > $thirdTeams[$maxScoreId]->getScore()) {
            $maxScoreId = $i;
          } else if($thirdTeams[$i]->getScore() == $thirdTeams[$maxScoreId]->getScore()) {
            if($thirdTeams[$i]->getGoals() > $thirdTeams[$maxScoreId]->getGoals()) {
              $maxScoreId = $i;
            } else if($thirdTeams[$i]->getGoals() == $thirdTeams[$maxScoreId]->getGoals()) {
              if($thirdTeams[$i]->getScored() < $thirdTeams[$maxScoreId]->getScored()) {
                $maxScoreId = $i;
              }
            }
          }
        }
        array_push($bestFour, $thirdTeams[$maxScoreId]);
        unset($thirdTeams[$maxScoreId]);
        $thirdTeams = array_values($thirdTeams);
        $maxScoreId = 0;
      }
      return $bestFour;
    }
  }
?>