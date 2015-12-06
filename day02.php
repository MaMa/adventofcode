<?php
$input = file_get_contents('input/day02.txt');

$rows = explode("\n", $input);
$paper = 0;
$ribbon = 0;
foreach($rows as $row) {
  if (!$row) continue;
  $sides = explode('x', trim($row));
  $xy = ($sides[0] * $sides[1]);
  $xz = ($sides[0] * $sides[2]);
  $yz = ($sides[1] * $sides[2]);
  $paper += 2*$xy + 2*$xz + 2*$yz + min([$xy, $xz, $yz]);

  $xx = $sides[0] * 2;
  $yy = $sides[1] * 2;
  $zz = $sides[2] * 2;
  $ribs = $xx + $yy + $zz - max([$xx, $yy, $zz]);
  $bow = ($sides[0] * $sides[1] * $sides[2]);
  $ribbon += $ribs + $bow;
}

print("Paper: ${paper}\n");
print("Ribbon: ${ribbon}\n");
