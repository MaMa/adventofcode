<?php
ini_set('memory_limit','256M');

$instructions = file('input/day06.txt');
$regex = '/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/';

$grid=[[]];
for ($x = 0; $x <= 999; $x++) {
  for ($y = 0; $y <= 999; $y++) {
    $grid[$x][$y] = 0;
  }
}

foreach ($instructions as $row) {
  if (!preg_match($regex, $row, $match)) continue;
  for ($x = $match[2]; $x <= $match[4]; $x++) {
    for ($y = $match[3]; $y <= $match[5]; $y++) {
      switch ($match[1]) {
        case 'turn on':
          $grid[$x][$y]++;
          break;
        case 'turn off':
          $grid[$x][$y]--;
          if ($grid[$x][$y] < 0) {
            $grid[$x][$y] = 0;
          }
          break;
        case 'toggle':
          $grid[$x][$y] += 2;
          break;
      }
    }
  }
}

$count = 0;
foreach ($grid as $row) {
  foreach ($row as $cell) {
    $count += $cell;
  }
}

print("\nBrightness: ${count}\n");
