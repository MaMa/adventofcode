<?php
ini_set('memory_limit','256M');

//*
  $input = file('input/day23.txt');
/*/
  $input = ['inc a','jio a, +2','tpl a','inc a'];
//*/

$in = [];
foreach ($input as $id => $row) {
  $in[$id] = explode(' ',trim($row));
}

$a = 0;
$b = 0;
$idx = 0;

runInstruction();
print("B: ${b}\n");

function runInstruction() {
  global $in, $a, $b, $idx;

  do {
    $cmd = $in[$idx];
    printf("%d\t%d\t%d\t%s\n", $idx, $a, $b, implode(' ', $cmd));
    $inc = true;
    switch ($cmd[0]) {
      case 'hlf':
          $$cmd[1] /= 2;
          break;
      case 'tpl':
          $$cmd[1] *= 3;
          break;
      case 'inc':
          $$cmd[1]++;
          break;
      case 'jmp':
          jmp($cmd[1]);
          $inc = false;
          break;
      case 'jie':
          $r = rtrim($cmd[1], ',');
          if ($$r % 2 == 0) {
            jmp($cmd[2]);
            $inc = false;
          }
          break;
      case 'jio':
          //print ("jio $idx -> ");
          $r = trim($cmd[1], ',');
          if ($$r == 1) {
            jmp($cmd[2]);
            $inc = false;
          }
          //print ("$idx\n");
          break;
      default:
          var_dump($cmd);
          die('Invalid cmd');
      //hlf r sets register r to half its current value, then continues with the next instruction.
      //tpl r sets register r to triple its current value, then continues with the next instruction.
      //inc r increments register r, adding 1 to it, then continues with the next instruction.
      //jmp offset is a jump; it continues with the instruction offset away relative to itself.
      //jie r, offset is like jmp, but only jumps if register r is even ("jump if even").
      //jio r, offset is like jmp, but only jumps if register r is 1 ("jump if one", not odd).
    }
    if ($inc) {$idx++;}
    usleep(1000);
  } while (isset($in[$idx]));
}

function jmp($val) {
  global $idx;
  if (!preg_match('/([+-])(\d+)/', $val, $match)) die("Invalid jmp ". $val);
  if ($match[1] == '+') $idx += $match[2];
  else $idx -= $match[2];
}
