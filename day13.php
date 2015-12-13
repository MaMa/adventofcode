<?php
ini_set('memory_limit','256M');

$in = file('input/day13.txt');
$regex = '/(\w+) would (gain|lose) (\d+) happiness units by sitting next to (\w+)./';

$sit = [];
foreach($in as $row) {
  if (!preg_match($regex, $row, $match)) continue;
  $who = $match[1];
  $points = $match[2] == 'gain' ? intval($match[3]) : intval('-'.$match[3]);
  $nextTo = $match[4];
  $sit[$who][$nextTo] = $points;
}

//permutations
function permute($arr) {
  $result = [];
  $rec = function($res, $rest) use (&$result, &$rec) {
    if (empty($rest)) {
      $result[] = $res;
      return;
    }
    foreach ($rest as $val) {
      $newRes = $res;
      $newRes[] = $val;
      $rec($newRes, array_diff($rest, $newRes));
    }
  };
  $rec([], $arr);
  return $result;
}
$permutations = permute(array_keys($sit));

function calcScore($seats) {
  global $sit;
  $len = count($seats);
  $score = 0;
  for ($i=0; $i<$len; $i++) {
    $self = $seats[$i];
    $left = $seats[($i-1+$len)%$len];
    $right = $seats[($i+1+$len)%$len];
    $score += $sit[$self][$left];
    $score += $sit[$self][$right];
  }
  return $score;
}

$scores = [];
foreach($permutations as $perm) {
  $idx = implode(', ', $perm);
  $scores[$idx] = calcScore($perm);
}

var_dump(max($scores));
