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
    for($i = 0; $i < count($this->groups); $i ++) {
      $this->groups[$i]->doGroupMatch();
      array_push($this->qualifieds, new Qualified($this->groups[$i]->getWinner(), true));
    }
  }

  public function doAllQualifiedMatch() {
    echo '<b>Továbbjutó mérkőzések:</b> <br>';

    while(count($this->qualifieds) > 2) {
      for($i = 0; $i < count($this->qualifieds); $i = $i+2) {
        if($i < count($this->qualifieds) - 1 && count($this->qualifieds) > 2) {
          $match = new FootballMatch($this->qualifieds[$i]->getTeam(), $this->qualifieds[$i + 1]->getTeam());
          echo $this->qualifieds[$i]->getTeam()->getCountry().' vs '.$this->qualifieds[$i + 1]->getTeam()->getCountry().'  ('.$match->getScore1().'-'.$match->getScore2().') <br>';
          
          if($match->getWinner() == null) {
            $this->qualifieds[$i]->setQualified(true);
            $this->qualifieds[$i + 1]->setQualified(true);
          } else {
            if($match->getWinner()->getCountry() == $this->qualifieds[$i]->getTeam() -> getCountry()) {
              $this->qualifieds[$i]->setQualified(true);
              $this->qualifieds[$i + 1]->setQualified(false);
            } else {
              $this->qualifieds[$i]->setQualified(false);
              $this->qualifieds[$i + 1]->setQualified(true);
            }
          }
        }
      }
      $this->removeUnQualifiedTeams();
    }
    $match = new FootballMatch($this->qualifieds[0]->getTeam(), $this->qualifieds[1]->getTeam());

    echo '<br><hr><b>Döntő</b>: '.$this->qualifieds[0]->getTeam()->getCountry().' vs '.$this->qualifieds[1]->getTeam()->getCountry().'  ('.$match->getScore1().'-'.$match->getScore2().') <br>';
  }

  private function removeUnQualifiedTeams() {
    $newQualifieds = array();
    for($i = 0; $i < count($this->qualifieds); $i ++) {
      if($this->qualifieds[$i]->isQualified()) {
        array_push($newQualifieds, new Qualified($this->qualifieds[$i]->getTeam(), true));
      } else {
        echo '<i>'.$this->qualifieds[$i]->getTeam()->getCountry().' kiesett. </i> <br>';
      }
    }
    $this->qualifieds = array();
    $this->qualifieds = $newQualifieds;
  }
}
?>