<?php

$target = 34000000;

function houseScore($num) {
  $score = $num;
  $start = floor($num/2);
  for ($i=$start;$i>0;$i--) {
    if ($num%$i == 0) $score += $i;
  }
  return $score * 10;
}

$house = 500000;
$score = 0;
do {
  $score = houseScore(++$house);
  print("$house\t$score\n");
} while ($score <= $target);

print ("\nAnswer: $house\n");
