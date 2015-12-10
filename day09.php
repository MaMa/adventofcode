<?php
ini_set('memory_limit','256M');

$input = file('input/day09.txt');
//$input = ['London to Dublin = 464', 'London to Belfast = 518', 'Dublin to Belfast = 141'];

$dists = [];
foreach ($input as $row) {
  if (!preg_match('/^(\w+) to (\w+) = (\d+)$/', $row, $match)) continue;
  $dists[$match[1]][$match[2]] = (int) $match[3];
  $dists[$match[2]][$match[1]] = (int) $match[3];
}

function remove_key($arr, $key) {
  unset($arr[$key]);
  return $arr;
}

function get_path_distance($path) {
  global $dists;
  $distance = 0;
  $from = array_shift($path);
  foreach($path as $dest) {
    //var_dump($from, $dest, $dists);
    $distance += $dists[$from][$dest];
    $from = $dest;
  }
  return $distance;
}

$g_paths = [];
function recurse($path, $dests) {

  if (empty($dests)) {
    global $g_paths;
    $key = implode(' > ', $path);
    $g_paths[$key] = get_path_distance($path);
    return;
  }

  foreach($dests as $to => $distance) {
    $new_path = $path;
    array_push($new_path, $to);
    recurse($new_path, remove_key($dests, $to));
  }
}

foreach ($dists as $start => $others) {
  foreach($others as $dest => $dist) {
    recurse([$start, $dest], remove_key(remove_key($others, $dest), $start));
  }
}

$min = min($g_paths);
$min_path = array_search($min, $g_paths);
print('Min Path: '. $min_path ."\n");
print('Min Length: '. $min ."\n");

$max = max($g_paths);
$max_path = array_search($min, $g_paths);
print('Max Path: '. $max_path ."\n");
print('Max Length: '. $max ."\n");
