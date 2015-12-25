<?php
// To continue, please consult the code grid in the manual.
// Enter the code at row 3010, column 3019.

$num = 20151125;
$row = 1;
$col = 1;
$nextRow = 2;
while(true) {
  //printf("%d\t%d\t%d\n", $row, $col, $num);
  if ($row <= 1) {
    $row = $nextRow++;
    $col = 1;
  } else {
    $row--;
    $col++;
  }
  $num = ($num * 252533) % 33554393;
  if ($row == 3010 && $col == 3019) {    
    var_dump([
      'row' => $row,
      'col' => $col,
      'num' => $num
    ]);
    die ();
  }
}
