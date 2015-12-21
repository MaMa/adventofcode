<?php

const TEST = false;
if (TEST) {
  $player = ['health' => 8, 'damage' => 5, 'armor' => 5];
  $enemy = ['health' => 12, 'damage' => 7, 'armor' => 2];
} else {
  $player = ['health' => 100, 'damage' => 0, 'armor' => 0];
  $enemy = ['health' => 103, 'damage' => 9, 'armor' => 2];
}

const PLAYER = 'player';
const ENEMY = 'enemy';

$equipment = [
  'Weapons' => [
    ['name' => 'Dagger',     'cost' => 8,  'damage' => 4, 'armor' => 0],
    ['name' => 'Shortsword', 'cost' => 10, 'damage' => 5, 'armor' => 0],
    ['name' => 'Warhammer',  'cost' => 25, 'damage' => 6, 'armor' => 0],
    ['name' => 'Longsword',  'cost' => 40, 'damage' => 7, 'armor' => 0],
    ['name' => 'Greataxe',   'cost' => 74, 'damage' => 8, 'armor' => 0]],
  'Armor' => [
    ['name' => 'None',       'cost' => 0,   'damage' => 0, 'armor' => 0],
    ['name' => 'Leather',    'cost' => 13,  'damage' => 0, 'armor' => 1],
    ['name' => 'Chainmail',  'cost' => 31,  'damage' => 0, 'armor' => 2],
    ['name' => 'Splintmail', 'cost' => 53,  'damage' => 0, 'armor' => 3],
    ['name' => 'Bandedmail', 'cost' => 75,  'damage' => 0, 'armor' => 4],
    ['name' => 'Platemail',  'cost' => 102, 'damage' => 0, 'armor' => 5]],
  'Rings' => [
    ['name' => 'None1',      'cost' =>    0, 'damage' => 0, 'armor' => 0],
    ['name' => 'None2',      'cost' =>    0, 'damage' => 0, 'armor' => 0],
    ['name' => 'Damage +1',  'cost' =>   25, 'damage' => 1, 'armor' => 0],
    ['name' => 'Damage +2',  'cost' =>   50, 'damage' => 2, 'armor' => 0],
    ['name' => 'Damage +3',  'cost' =>  100, 'damage' => 3, 'armor' => 0],
    ['name' => 'Defense +1', 'cost' =>   20, 'damage' => 0, 'armor' => 1],
    ['name' => 'Defense +2', 'cost' =>   40, 'damage' => 0, 'armor' => 2],
    ['name' => 'Defense +3', 'cost' =>   80, 'damage' => 0, 'armor' => 3]]];

$ringCount = count($equipment['Rings']);

$minCost = 99999;
$maxCost = 0;
foreach ($equipment['Weapons'] as $weapon) {
  foreach ($equipment['Armor'] as $armor) {
    for ($i=0;$i<$ringCount-1;$i++) {
      $ring1 = $equipment['Rings'][$i];
      for ($j=$i+1;$j<$ringCount;$j++){
        $ring2 = $equipment['Rings'][$j];
        $items = [$weapon, $armor, $ring1, $ring2];
        $fighter = equip($player, $items);
        $result = fight($fighter, $enemy);
        if ($result == PLAYER) {
          if ($fighter['cost'] < $minCost) {
            $minCost = $fighter['cost'];
          }
        } elseif($result == ENEMY) {
          if ($fighter['cost'] > $maxCost) {
            $maxCost = $fighter['cost'];
          }
        }
      }
    }
  }
}

print("MinCost to win: $minCost \n");
print("MaxCost to lose: $maxCost \n");

function equip($player, $equipment) {
  $player['cost'] = 0;
  foreach ($equipment as $item) {
    $player['damage'] += $item['damage'];
    $player['armor']  += $item['armor'];
    $player['cost']   += $item['cost'];
  }
  return $player;
}

function fight($player, $enemy, $debug=false) {
  while(true) {
    $enemy['health'] -= calcDamage($player['damage'], $enemy['armor']);
    if ($debug) debug(ENEMY, $enemy);
    if ($enemy['health'] <= 0) return PLAYER;
    $player['health'] -= calcDamage($enemy['damage'], $player['armor']);
    if ($debug) debug(PLAYER, $player);
    if ($player['health'] <= 0) return ENEMY;
  }
}

function calcDamage($damage, $armor) {
  $hit = $damage - $armor;
  return ($hit > 0) ? $hit : 1;
}

function debug($title, $char) {
  printf("%s %d %d %d\n", $title, $char['health'], $char['damage'], $char['armor']);
}
