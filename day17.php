<?php
/**
--- Day 17: No Such Thing as Too Much ---

The elves bought too much eggnog again - 150 liters this time. To fit it all
into your refrigerator, you'll need to move it into smaller containers. You take
an inventory of the capacities of the available containers.

For example, suppose you have containers of size 20, 15, 10, 5, and 5 liters.
If you need to store 25 liters, there are four ways to do it:

15 and 10
20 and 5 (the first 5)
20 and 5 (the second 5)
15, 5, and 5
Filling all containers entirely, how many different combinations of containers
can exactly fit all 150 liters of eggnog?
*/

const TEST = false;
if (TEST) {
  $containers = [20,15,10,5,5];
  $amount = 25;
} else {
  $containers = [33,14,18,20,45,35,16,35,1,13,18,13,50,44,48,6,24,41,30,42];
  sort($containers);
  $amount = 150;
}

$score = 0;
$counts = [];
function fill($amount, $jars, $count=0) {
  if ($amount === 0) {
    global $score, $counts;
    $counts[$count]++;
    $score++;
    return;
  }

  for ($i=0; $i<count($jars); $i++) {
    $rest = array_slice($jars, $i+1);
    if ($amount >= $jars[$i]) {
      fill($amount-$jars[$i], $rest, $count+1);
    }
  }
}

fill($amount, $containers);
print("Combinations: ${score}\n");

sort($counts);
$min = array_shift($counts);
print("Minimum: ${min}\n");
