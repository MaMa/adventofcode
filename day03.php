<?php
$moves = str_split(file_get_contents('input/day03.txt'));
$moves[] = 'end';
$index = 0;
$santa = [
  0 => ['x' => 0, 'y' => 0],
  1 => ['x' => 0, 'y' => 0]
];
$count = count($santa);
$world = [0=>[0=>$count]];

//move santa
foreach ($moves as $move) {
  $s = &$santa[$index++ % $count];
  switch ($move) {
    case '>':
      $s['x']++;
      break;
    case '<':
      $s['x']--;
      break;
    case '^':
      $s['y']++;
      break;
    case 'v':
      $s['y']--;
      break;
  }
  $world[$s['x']][$s['y']]++;
}

//count houses
$count = 0;
foreach($world as $rows) {
  foreach ($rows as $columns) $count++;
}

print ("Houses: ${count}\n");
