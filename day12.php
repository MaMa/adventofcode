<?php

$doc = json_decode(file_get_contents('input/day12.json'));

function getSum($obj) {
  $sum = 0;
  if (is_numeric($obj)) {
    $sum += $obj;
  } elseif (is_object($obj)) {
    foreach ($obj as $key => $value) {
      if (is_numeric($key)) $sum += $key;
      $sum += getSum($value);
    }
  } elseif (is_array($obj)) {
    foreach ($obj as $value) {
      $sum += getSum($value);
    }
  }
  return $sum;
}

var_dump(getSum($doc));
