<?php
$input = file_get_contents('day02-input.txt');

$rows = explode("\n", $input);
$paper = 0;
foreach($rows as $row) {
  if (!$row) continue;
  $sides = explode('x', trim($row));
  $xy = ($sides[0] * $sides[1]);
  $xz = ($sides[0] * $sides[2]);
  $yz = ($sides[1] * $sides[2]);
  $paper += 2*$xy + 2*$xz + 2*$yz + min([$xy, $xz, $yz]);
}
print("Answer: ${paper}\n");
