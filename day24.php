<?php
ini_set('memory_limit', '256M');
/*
$in = [1,2,3,4,5,7,8,9,10,11];
/*/
$in = array_map('intval', file('input/day24.txt'));
//*/

const PART_2 = true;

$sum = array_sum($in);
$target = $sum / (PART_2 ? 4 : 3);

print ("Target of ${sum} = ${target}\n");

$results = [];
$minPkgs = 999;
function iter($packs, $res=[]) {
  global $target, $results, $minPkgs;
  $diff = $target - array_sum($res);
  if ($diff == 0) {
    $pkgs = count($res);
    if ($pkgs < $minPkgs) {
      $minPkgs = $pkgs;
      $results = [$res];
    } elseif ($pkgs == $minPkgs) {
      $results[] = $res;
    }
  } else for ($i=0;$i<count($packs);$i++) {
    $num = $packs[$i];
    if ($num <= $diff) {
      $newRes = $res;
      $newRes[] = $num;
      iter(array_slice($packs, $i+1), $newRes);
    }
  }
}

iter($in);
var_dump($results);

$minQE = NULL;
foreach($results as $pkgs) {
  $qe = array_product($pkgs);
  if (!$minQE) $minQE = $qe;
  elseif ($qe < $minQe) $minQe = $qe;
}

print ("Optimal QE: ${minQE}\n");
