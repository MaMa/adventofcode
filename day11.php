<?php
/**
--- Day 11: Corporate Policy ---

Santa's previous password expired, and he needs help choosing a new one.

To help him remember his new password after the old one expires, Santa has devised a method of coming up with a password based on the previous one. Corporate policy dictates that passwords must be exactly eight lowercase letters (for security reasons), so he finds his new password by incrementing his old password string repeatedly until it is valid.

Incrementing is just like counting with numbers: xx, xy, xz, ya, yb, and so on. Increase the rightmost letter one step; if it was z, it wraps around to a, and repeat with the next letter to the left until one doesn't wrap around.

Unfortunately for Santa, a new Security-Elf recently started, and he has imposed some additional password requirements:

Passwords must include one increasing straight of at least three letters, like abc, bcd, cde, and so on, up to xyz. They cannot skip letters; abd doesn't count.
Passwords may not contain the letters i, o, or l, as these letters can be mistaken for other characters and are therefore confusing.
Passwords must contain at least two different, non-overlapping pairs of letters, like aa, bb, or zz.
For example:

hijklmmn meets the first requirement (because it contains the straight hij) but fails the second requirement requirement (because it contains i and l).
abbceffg meets the third requirement (because it repeats bb and ff) but fails the first requirement.
abbcegjk fails the third requirement, because it only has one double letter (bb).
The next password after abcdefgh is abcdffaa.
The next password after ghijklmn is ghjaabcc, because you eventually skip all the passwords that start with ghi..., since i is not allowed.
Given Santa's current password (your puzzle input), what should his next password be?

Your puzzle input is hepxcrrq
*/

function nextPass($pass) {
  $chars = str_split($pass);
  $idx = count($chars)-1;
  do {
    if ($chars[$idx] == 'z') {
      $chars[$idx] = 'a';
      $idx--;
    } else {
      $chars[$idx] = chr(ord($chars[$idx])+1);
      $idx = -1;
    }
  } while ($idx >= 0);
  return implode($chars);
}

function isValid($pass) {
  if (preg_match('/(i|o|l)/', $pass)) return false;
  $chars = str_split($pass);
  if (!hasIncreasing($chars)) return false;
  if (!hasPairs($chars)) return false;
  return true;
}

function hasIncreasing($chars) {
  $len = count($chars)-2;
  for ($i=0; $i<$len; $i++) {
    if (ord($chars[$i]) == (ord($chars[$i+1])-1) &&
        ord($chars[$i]) == (ord($chars[$i+2])-2)) return true;
  }
  return false;
}

function hasPairs($chars) {
  $len = count($chars);
  for ($i=0; $i<$len-3; $i++) {
    if ($chars[$i] == $chars[$i+1]) {
      for ($j=$i+2; $j<$len; $j++) {
        if ($chars[$i] != $chars[$j] && $chars[$j] == $chars[$j+1]) return true;
      }
    }
  }
  return false;
}

$pass = 'hepxcrrq'; //part1
$pass = 'hepxxyzz'; //part2
do {
  $pass = nextPass($pass);
  //print ("${pass}\n");
} while(!isValid($pass));

print ("${pass}\n");
