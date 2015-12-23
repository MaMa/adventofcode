<?php
//*
$player = ['health' => 50, 'mana' => 500, 'armor' => 0];
$enemy  = ['health' => 71, 'damage' => 10, 'armor' => 0];
/*/
$player = ['health' => 10, 'mana' => 250, 'armor' => 0];
$enemy  = ['health' => 14, 'damage' => 8, 'armor' => 0];
//*/

$spells = [
  'missile'  => ['cost' =>  53, 'duration' => 1],
  'drain'    => ['cost' =>  73, 'duration' => 1],
  'shield'   => ['cost' => 113, 'duration' => 6],
  'poison'   => ['cost' => 173, 'duration' => 6],
  'recharge' => ['cost' => 229, 'duration' => 5]];

$state = [
  'rounds' => 0,
  'used' => 0,
  'player' => $player,
  'enemy'  => $enemy,
  'effects' => []];

$minState = ['used' => 99999];
playerRound($state);
printHistory($minState);
print ('MinMana '. $minState['used'] ."\n");
//1481, 1394 is too low ?!?

$iters = 0;
function playerRound($state) {
  global $iters, $minMana;
  $state['history'][$state['rounds']++] = getHistory($state);
  $state = applyEffects($state);
  if (checkFinished($state)) return;
  foreach(pickSpells($state) as $spell) {
    enemyRound(castSpell($spell, $state));
  }
}

function getHistory($state) {
  return [
    'hp' => $state['player']['health'],
    'mn' => $state['player']['mana'],
    'en' => $state['enemy']['health'],
    'ef' => $state['effects']];
}

function enemyRound($state) {
  $state['history'][$state['rounds']++] = getHistory($state);
  $state = applyEffects($state);
  if (checkFinished($state)) return;

  //enemy attack
  $damage = $state['enemy']['damage'] - $state['player']['armor'];
  if ($damage < 1) $damage = 1;
  $state['player']['health'] -= $damage;
  if (checkFinished($state)) return;
  return playerRound($state);
}

function applyEffects($state) {
  //apply effects
  $effects = $state['effects'];
  foreach ($effects as $effect => $count) {
    $effects[$effect] = $count-1;
    switch($effect) {
      case 'missile':
        $state['enemy']['health'] -= 4;
        break;
      case 'drain':
        $state['enemy']['health'] -= 2;
        $state['player']['health'] += 2;
        break;
      case 'shield':
        $state['player']['armor'] = 7;
        break;
      case 'poison':
        $state['enemy']['health'] -= 3;
        break;
      case 'recharge':
        $state['player']['mana'] += 101;
        break;
      default:
        die('Invalid effect '. $effect);
    }
  }
  //Clear expired effects
  foreach ($effects as $effect => $count) {
    if ($count <= 0) {
      if ($effect == 'shield') {
        $state['player']['armor'] = 0;
      }
      unset($effects[$effect]);
    }
  }
  $state['effects'] = $effects;
  return $state;
}

function castSpell($spell, $state) {
  if (isset($state['effects'][$spell])) {
    die ($spell . ' already active');
  }
  global $spells;
  if (!$spells[$spell]) die('invalid spell '. $spell);
  $state['used'] += $spells[$spell]['cost'];
  $state['player']['mana'] -= $spells[$spell]['cost'];
  $state['effects'][$spell] = $spells[$spell]['duration'];
  return $state;
}

function checkFinished($state) {
  global $minState;
  if ($state['used'] >= $minState['used']) {
    //too expensive
    return true;
  }
  if ($state['player']['health'] <= 0 || $state['player']['mana'] <= 0) {
    //print("\t\t\tDie\n");
    return true;
  }
  if ($state['enemy']['health'] <= 0) {
    if ($state['used'] < $minState['used']) {
      $minState = $state;
    }
    return true;
  }
  return false;
}

function printHistory($state) {
  foreach($state['history'] as $round => $stats) {
    $effects = [];
    foreach($stats['ef'] as $eff => $dur) {
      $effects[] = $eff . "($dur)";
    }
    printf("%d\thp: %d\tmana: %d\tenemy: %s\t%s\n",
      $round, $stats['hp'], $stats['mn'], $stats['en'], implode(',',$effects));
  }
}

function pickSpells($state) {
  global $spells;
  $available = [];
  foreach ($spells as $spell => $stats) {
    if (!isset($state['effects'][$spell]) && $state['player']['mana'] > $stats['cost']) {
      $available[] = $spell;
    }
  }
  return $available;
}
