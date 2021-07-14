<?php

require('Championship.php');

$championship = new Championship();
$championship->initGroups();
$championship->doAllGroupMatch();
$championship->doAllQualifiedMatch();

?>