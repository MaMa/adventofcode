<?php
$moves = str_split(file_get_contents('input/day03.txt'));
$world = [0=>[0=>1]];
$x = 0;
$y = 0;

//move santa
foreach ($moves as $move) {
  switch ($move) {
    case '>':
      $x++;
      break;
    case '<':
      $x--;
      break;
    case '^':
      $y++;
      break;
    case 'v':
      $y--;
      break;
  }
  $world[$x][$y]++;
}

//count houses
$count = 0;
foreach($world as $rows) {
  foreach ($rows as $columns) $count++;
}

print ("Houses: ${count}\n");
