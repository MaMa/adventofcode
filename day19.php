<?php

const TEST = true;
if (TEST) {
  $trans = [
    'H' => ['HO', 'OH'],
    'O' => ['HH'],
  ];
  $string = 'HOHOHO';
} else {
  
}

$results = [];
$strLen = strlen($string);
foreach ($trans as $key => $values) {
  $keyLen = strlen($key);
  for ($i=0; $i<=($strLen-$keyLen); $i++) {
    if (substr($string, $i, $keyLen) === $key) {
      $start = substr($string, 0, $i);
      $end = substr($string, $i+$keyLen);
      foreach($values as $replace) {
        $results[] = $start . $replace . $end;
      }
    }
  }
}
print ("Uniques: ".count(array_unique($results)) ."\n");
