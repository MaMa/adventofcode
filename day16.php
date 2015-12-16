<?php

$in = file('input/day16.txt');
$regex = '/Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)/';
$sues = [];
foreach($in as $row) {
  if (!preg_match($regex, $row, $match)) continue;
  $sues[$match[1]] = [
    $match[2] => intval($match[3]),
    $match[4] => intval($match[5]),
    $match[6] => intval($match[7]),
  ];
}
$target = [
  'children' => 3,
  'cats' => 7,
  'samoyeds' => 2,
  'pomeranians' => 3,
  'akitas' => 0,
  'vizslas' => 0,
  'goldfish' => 5,
  'trees' => 3,
  'cars' => 2,
  'perfumes' => 1];

foreach ($sues as $id => $sue) {
  foreach ($sue as $info => $num) {
    if ($target[$info] !== $num) {
      unset($sues[$id]);
      continue(2);
    }
  }
}

var_dump($sues);
