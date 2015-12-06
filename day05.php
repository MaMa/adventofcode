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

print("Naughty: ${naughty}\n");
print("Nice: ${nice}\n");
