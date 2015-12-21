<?php

const TEST = true;
if (TEST) {
  $player = ['health' => 8, 'damage' => 5, 'armor' => 5];
  $enemy = ['health' => 12, 'damage' => 7, 'armor' => 2];
} else {
  $player = ['health' => 100, 'damage' => 0, 'armor' => 0];
  $enemy = ['health' => 103, 'damage' => 9, 'armor' => 2];
}

const PLAYER = 'player';
const ENEMY = 'enemy';

var_dump(fight($player, $enemy));

function fight($player, $enemy) {
  do {
    $enemy['health'] -= calcDamage($player['damage'], $enemy['armor']);
    if ($enemy['health'] <= 0) return PLAYER;
    $player['health'] -= calcDamage($enemy['damage'], $player['armor']);
  } while($player['health'] > 0);
  return ENEMY;
}

function calcDamage($damage, $armor) {
  $hit = $damage - $armor;
  if ($hit <= 1) $hit = 1;
  return $hit;
}
