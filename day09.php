<?php

$routes = [];
foreach (file('input/day09.txt') as $row) {
  if (!preg_match('/^(\w+) to (\w+) = (\d+)$/', $row, $match)) continue;
  $routes[$match[1]][$match[2]] = $match[3];
}

var_dump($routes);
