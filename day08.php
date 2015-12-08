<?php

$input = file('input/day08.txt');

$mem = 0;
$chars = 0;
$escaped = 0;
foreach($input as $in) {
  $string = trim($in);
  if (empty($string)) continue;
  $mem += strlen($string);
  $clean = preg_replace('/\\\\x[0-9a-f]{2}/','X',
    str_replace('\\"', '"',
      str_replace('\\\\', '_',
        preg_replace('/^\"|\"$/', '', $string)
      )
    )
  );

  $enc = '"'. addslashes($string) .'"';
  $escaped += strlen($enc);
  $chars += strlen($clean);
}

print("Mem ${mem}\n");
print("Chars ${chars}\n");
print("Escaped ${escaped}\n");
print("Mem - Chars: " . ($mem - $chars) ."\n");
print("Escaped - Mem: " . ($escaped - $mem) ."\n");
