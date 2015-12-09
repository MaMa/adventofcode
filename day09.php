<?php
ini_set('memory_limit','1G');

$dists = [];

//$input = file('input/day09.txt');
$input = ['London to Dublin = 464','London to Belfast = 518','Dublin to Belfast = 141'];

foreach ($input as $row) {
  if (!preg_match('/^(\w+) to (\w+) = (\d+)$/', $row, $match)) continue;
  $dists[$match[1]][$match[2]] = (int) $match[3];
  $dists[$match[2]][$match[1]] = (int) $match[3];
}

function remove_key($arr, $key) {
  unset($arr[$key]);
  return $arr;
}

$g_paths = [];
function recurse($dests, $result) {
  if (empty($dests)) {
    global $g_paths;
    $path = implode(' > ', $result['path']);
    $g_paths[$path] = $result['dist'];
    return;
  }
  foreach($dests as $to => $dist) {
    $path = $result['path'];
    $path[] = $to;
    $new_dist = $result['dist'] + $dist;
    $new_result = ['path' => $path, 'dist' => $new_dist];
    recurse(remove_key($dests, $to), $new_result);
  }

}

foreach ($dists as $start => $others) {
  foreach($others as $dest => $dist) {
    $res = ['path' => [$start, $dest], 'dist' => $dist];
    recurse(remove_key($others, $dest), $res);
  }
}

var_dump($g_paths);
$min = min($g_paths);
print('Shortest path: '. $min ."\n");
