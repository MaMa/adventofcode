<?php

//*
$in = [1,2,3,4,5,7,8,9,10,11];
/*/
$in = array_map('intval', file('input/day24.txt'));
//*/

$sum = array_sum($in);
$third = $sum / 3;
$splits = [];

$result = [];
pick($in, $sum / 3);
$firsts = $result;

foreach ($firsts as $first) {
  sort($first);
  $result = [];
  $avs = array_filter($in, function($n) use ($first) {
    return !in_array($n, $first);
  });
  pick($avs, $sum / 3);

  foreach($result as $second) {
    sort($second);
    $third = array_filter($in, function($n) use ($first, $second) {
      return !in_array($n, $first) && !in_array($n, $second);
    });
    sort($third);
    $splits[] = [$first, $second, $third];
  }
}

$sers = [];
foreach ($splits as $row) {
  $sers[] = serialize($row);
}

$combos = [];
foreach(array_unique($sers) as $ser) {
  $combos[] = unserialize($ser);
}

usort($combos, function($row1, $row2) {
  $c1 = count($row1[0]);
  $c2 = count($row2[0]);
  if ($c1 == $c2) {
    $q1 = countQE($row1[0]);
    $q2 = countQE($row1[0]);
    if ($q1 == $q2) return 0;
    else return ($q1 < $q2) ? -1 : 1;
  }
  else return ($c1 < $c2) ? -1 : 1;
});

function countQE($parts) {
  return array_product($parts);
}

foreach ($combos as $row) {
  foreach ($row as $c) {
    print(implode(' ', $c) . ' | ');
  }
  print ("\n");
}

$QE = countQE($combos[0][0]);
print("QE for first combo ". $QE . "\n");

function pick($available, $target, $picked=[]) {
  $diff = $target - array_sum($picked);
  if ($diff === 0) {
    global $result;
    sort($picked);
    $result[] = $picked;
  } else foreach ($available as $num) {
    if ($num <= $diff) {
      $avaDiff = array_filter(
        $available,
        function($n) use ($num) {
          return $num !== $n;
        });
      $pickNum = $picked;
      $pickNum[] = $num;
      pick($avaDiff, $target, $pickNum);
    }
  }
}
