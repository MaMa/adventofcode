<?php

$doc = json_decode(file_get_contents('input/day12.json'));

function getSum($obj) {
  $sum = 0;
  if (is_numeric($obj)) {
    $sum += $obj;
  } elseif (is_object($obj)) {
    if (!hasRed($obj)) {
      foreach ($obj as $key => $value) {
        if (is_numeric($key)) $sum += $key;
        $sum += getSum($value);
      }
    }
  } elseif (is_array($obj)) {
    foreach ($obj as $value) {
      $sum += getSum($value);
    }
  }
  return $sum;
}

function hasRed($obj) {
  if (is_string($obj)) return ($obj === 'red');
  elseif (is_object($obj)) {
    foreach ($obj as $val) {
      if (is_string($val) && $val === 'red') return true;
    }
  }
  return false;
}

function test($json) {
  print($json .' -> '.getSum(json_decode($json)) ."\n");
}

test('[1,2,3]');
test('[1,{"c":"red","b":2},3]');
test('{"d":"red","e":[1,2,3,4],"f":5}');
test('[1,"red",5]');

//without reds
var_dump(getSum($doc));
