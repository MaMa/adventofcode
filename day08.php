<?php

$input = file('input/day08.txt');

$mem = 0;
$chars = 0;
foreach($input as $in) {
  $string = trim($in);
  $mem += strlen($string);
  $clean = preg_replace('/\\\\x[0-9a-f]{2}/','X',
    str_replace('\\"', '"',
      str_replace('\\\\', '_',
        preg_replace('/^\"|\"$/', '', $string)
      )
    )
  );
  $chars += strlen($clean);
}

print("Mem ${mem}\n");
print("Chars ${chars}\n");
$diff = $mem - $chars;
print("Diff ${diff}\n");
