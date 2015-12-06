<?php

$strings = file('input/day05.txt');

$naughty = 0;
$nice = 0;
foreach ($strings as $string) {
  //It does not contain the strings ab, cd, pq, or xy,
  //even if they are part of one of the other requirements.
  if (preg_match('/ab|cd|pq|xy/', $string)) {
    $naughty++;
    continue;
  }

  //It contains at least three vowels (aeiou only), like aei, xazegov, or aeiouaeiouaeiou.
  $vowels = preg_replace('/[^aeiou]/','', $string);
  if (strlen($vowels) <3) {
    $naughty++;
    continue;
  }

  //It contains at least one letter that appears twice in a row,
  //like xx, abcdde (dd), or aabbccdd (aa, bb, cc, or dd).
  $chars = str_split($string);
  for ($i = 0; $i < count($chars) - 1; $i++) {
    if ($chars[$i] === $chars[$i+1]) {
      $nice++;
      continue(2);
    }
  }
  $naughty++;
}
print("Part 1\n");
print("Naughty: ${naughty}\n");
print("Nice: ${nice}\n");

// Part 2
$naughty = 0;
$nice = 0;
foreach ($strings as $string) {
  $len = strlen($string);
  $chars = str_split($string);
  //It contains a pair of any two letters that appears at least twice
  //in the string without overlapping, like xyxy (xy) or aabcdefgaa (aa),
  //but not like aaa (aa, but it overlaps).
  $match = false;
  for ($i = 0; $i < $len - 3; $i++) {
    $first = substr($string, $i, 2);
    for ($j = $i+2; $j<$len-1; $j++) {
      $second = substr($string, $j, 2);
      if ($first === $second) {
        $match = true;
        break;
      }
    }
  }
  if (!$match) {
    $naughty++;
    continue;
  }

  //It contains at least one letter which repeats with exactly one letter
  //between them, like xyx, abcdefeghi (efe), or even aaa.
  $match = false;
  for ($i = 0; $i < $len-2; $i++) {
    $first = substr($string, $i, 1);
    $second = substr($string, $i+2, 1);
    if ($first === $second) {
      $match = true;
      break;
    }
  }
  if (!$match) {
    $naughty++;
  } else {
    $nice++;
  }
}
print("\nPart 2\n");
print("Naughty: ${naughty}\n");
print("Nice: ${nice}\n");
