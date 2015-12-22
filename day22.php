<?php

$player = ['health' => 50, 'mana' => 500, 'armor' => 0];
$enemy  = ['health' => 71, 'damage' => 10, 'armor' => 0];

$spells = [
  'missile'  => ['cost' => 53],
  'drain'    => ['cost' => 73],
  'shield'   => ['cost' => 113],
  'poison'   => ['cost' => 173],
  'recharge' => ['cost' => 229]];

$state = [
  'player' => $player,
  'enemy'  => $enemy,
  'effects' => []];

fightRound($state);

function fightRound($state) {
  $availableSpells = pickSpells($state['player']['mana'], $state['effects']);
  var_dump($availableSpells);
}

function pickSpells($mana, $effects) {
  global $spells;
  $active = array_keys($effects);
  $available = [];
  foreach ($spells as $spell => $stats) {
    if (!isset($active['spell']) && $mana > $stats['cost']) {
      $available[$spell] = $stats;
    }
  }
  return $available;
}
