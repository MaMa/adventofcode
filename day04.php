<?php
$key = 'iwrupvqb';
$count = 0;
do {
  $coin = md5($key . ++$count);
} while (substr($coin, 0,5) !== '00000');

print("Coin ${coin} with count ${count}\n");
