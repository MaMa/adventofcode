<?php
$key = 'iwrupvqb';
$count = 0;
do {
  $coin = md5($key . ++$count);
} while (substr($coin, 0, 6) !== '000000');

print("Coin ${coin} with count ${count}\n");
