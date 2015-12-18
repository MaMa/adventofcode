<?php

const TEST = false;
const PART_2 = true;
if (TEST) {
  $in = ['.#.#.#','...##.','#....#','..#...','#.#..#','####..'];
  $steps = PART_2 ? 5 : 4;
} else {
  $in = file('input/day18.txt');
  $steps = 100;
}

$grid = [];
foreach($in as $y => $row) {
  foreach(str_split($row) as $x => $char) {
    if ($char !== '#' && $char !== '.') continue;
    $grid[$y][$x] = ($char == '#');
  }
}

if (PART_2) {
  $grid = stuckLights($grid);
}

function printGrid($grid) {
  foreach($grid as $y => $row) {
    foreach($row as $x => $on) {
      print $on ? '*' : '.';
    }
    print "\n";
  }
}

function stuckLights($grid) {
  $ymax = count($grid)-1;
  $xmax = count($grid[0])-1;
  $grid[0][0] = true;
  $grid[$ymax][0] = true;
  $grid[0][$xmax] = true;
  $grid[$ymax][$xmax] = true;
  return $grid;
}

function iterate($grid) {
  //count neighbors
  $ngrid = [];
  foreach($grid as $y => $row) {
    foreach($row as $x => $on) {
      $n = $on ? -1 : 0; //subtract one if on
      for ($i=$y-1;$i<=$y+1;$i++) {
        for ($j=$x-1;$j<=$x+1;$j++) {
          if ($grid[$i][$j]) $n++;
        }
      }
      $ngrid[$y][$x]=$n;
    }
  }
  //Next iteration
  $newGrid = [];
  foreach($ngrid as $y => $row) {
    foreach($row as $x => $n) {
      if ($grid[$y][$x]) {
        //A light which is on stays on when 2 or 3 neighbors are on, and turns off otherwise.
        $newGrid[$y][$x] = ($n == 2 || $n == 3);
      } else {
        //A light which is off turns on if exactly 3 neighbors are on, and stays off otherwise.
        $newGrid[$y][$x] = ($n == 3);
      }
    }
  }

  if (PART_2) {
    return stuckLights($newGrid);
  }

  return $newGrid;
}

//loop
for ($i=0;$i<$steps;$i++) {
  $grid = iterate($grid);
}

//result
$count=0;
foreach($grid as $y => $row) {
  foreach($row as $x => $on) {
    if ($on) $count ++;
  }
}

printGrid($grid);

print("Lights lit: ${count}\n");
