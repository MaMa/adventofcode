<?php
/**
--- Day 15: Science for Hungry People ---

Today, you set out on the task of perfecting your milk-dunking cookie recipe. All you have to do is find the right balance of ingredients.

Your recipe leaves room for exactly 100 teaspoons of ingredients. You make a list of the remaining ingredients you could use to finish the recipe (your puzzle input) and their properties per teaspoon:

capacity (how well it helps the cookie absorb milk)
durability (how well it keeps the cookie intact when full of milk)
flavor (how tasty it makes the cookie)
texture (how it improves the feel of the cookie)
calories (how many calories it adds to the cookie)
You can only measure ingredients in whole-teaspoon amounts accurately, and you have to be accurate so you can reproduce your results in the future. The total score of a cookie can be found by adding up each of the properties (negative totals become 0) and then multiplying together everything except calories.

For instance, suppose you have these two ingredients:

Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8
Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3
Then, choosing to use 44 teaspoons of butterscotch and 56 teaspoons of cinnamon (because the amounts of each ingredient must add up to 100) would result in a cookie with the following properties:

A capacity of 44*-1 + 56*2 = 68
A durability of 44*-2 + 56*3 = 80
A flavor of 44*6 + 56*-2 = 152
A texture of 44*3 + 56*-1 = 76
Multiplying these together (68 * 80 * 152 * 76, ignoring calories for now) results in a total score of 62842880, which happens to be the best score possible given these ingredients. If any properties had produced a negative total, it would have instead become zero, causing the whole score to multiply to zero.

Given the ingredients in your kitchen and their properties, what is the total score of the highest-scoring cookie you can make?
*/

const TEST = false;

if (TEST) {
  $in = [
    'Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8',
    'Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3'];
} else {
  $in = file('input/day15.txt');
}

$regex = '/(\w+): capacity ([-\w]+), durability ([-\w]+), flavor ([-\w]+), texture ([-\w]+), calories ([-\w]+)/';
$ingredients = [];
foreach($in as $row) {
  if (!preg_match($regex, $row, $match)) continue;
  $ingredients[] = [
    'name' => $match[1],
    'capacity' => intval($match[2]),
    'durability' => intval($match[3]),
    'flavor' => intval($match[4]),
    'texture' => intval($match[5]),
    'calories' => intval($match[6]),
  ];
}

function valueOf(array $portions) {
  global $ingredients;
  if (count($portions) != count($ingredients)) throw new Exception('count mismatch');
  if (array_sum($portions) !== 100) throw new Exception('Not 100');

  $take = ['capacity', 'durability', 'flavor', 'texture'];
  $values = [];
  foreach($portions as $id => $portion) {
    foreach ($take as $ing) {
      $values[$ing] += $ingredients[$id][$ing] * $portion;
    }
  }
  //if any is negative the product is 0;
  foreach ($values as $val) {
    if ($val < 0) return 0;
  }
  return array_product($values);
}

$max = 0;
function permute4($x) {
  $n = $x+1;
  for ($i=0; $i<$n; $i++) {
    for ($j=0; $j<$n-$i; $j++) {
      for ($k=0; $k<$n-$i-$j; $k++) {
        $l = $n-$i-$j-$k-1;
        //printf("%d\t%d\t%d\t%d\n", $i, $j, $k, $l);
        $val = valueOf([$i, $j, $k, $l]);
        if ($val > $max) {
          $max = $val;
          //var_dump([$i, $j, $k, $l], $val);
        }
      }
    }
  }
  print ("MAX $max \n");
}

function permute2($x) {
  global $max, $ingredients;
  $n = $x+1;
  for ($i=0; $i<$n; $i++) {
    $j = $n-$i-1;
    $val = valueOf([$i, $j]);
    if ($val > $max) {
      $max = $val;
      //var_dump([$i, $j], $val);
    }
  }
  print ("MAX $max \n");
}

if (TEST) {
  permute2(100);
} else {
  permute4(100);
}
