<?php
/**
This year is the Reindeer Olympics! Reindeer can fly at high speeds, but must
rest occasionally to recover their energy. Santa would like to know which of
his reindeer is fastest, and so he has them race.

Reindeer can only either be flying (always at their top speed) or resting (not
moving at all), and always spend whole seconds in either state.

For example, suppose you have the following Reindeer:

Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.
Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.
After one second, Comet has gone 14 km, while Dancer has gone 16 km. After ten
seconds, Comet has gone 140 km, while Dancer has gone 160 km. On the eleventh
second, Comet begins resting (staying at 140 km), and Dancer continues on for
a total distance of 176 km. On the 12th second, both reindeer are resting.
They continue to rest until the 138th second, when Comet flies for another ten
seconds. On the 174th second, Dancer flies for another 11 seconds.

In this example, after the 1000th second, both reindeer are resting, and Comet
is in the lead at 1120 km (poor Dancer has only gotten 1056 km by that point).
So, in this situation, Comet would win (if the race ended at 1000 seconds).

Given the descriptions of each reindeer (in your puzzle input), after exactly
2503 seconds, what distance has the winning reindeer traveled?
*/

$input = [
  'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
  'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.'
];

const MODE_START = 1;
const MODE_RUN   = 2;
const MODE_REST  = 3;

$regex='/(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds./';
$reindeers = [];
foreach($input as $row) {
  if (!preg_match($regex, $row, $match)) continue;
  $reindeers[$match[1]] = [
    'speed' => intval($match[2]),
    'time' => intval($match[3]),
    'rest' => intval($match[4]),
    'state' => MODE_START,
    'count' => null,
    'distance' => 0,
    'ticks' => 0
  ];
}

function tick(&$r) {
  switch ($r['state']) {
    case MODE_START:
      $r['state'] = MODE_RUN;
      $r['distance'] += $r['speed'];
      $r['count'] = $r['time']-1;
      break;
    case MODE_RUN:
      if ($r['count'] <= 0) {
        $r['state'] = MODE_REST;
        $r['count'] = $r['rest']-1;
      }
      $r['distance'] += $r['speed'];
      break;
    case MODE_REST:
      if ($r['count'] <= 0) {
        $r['state'] = MODE_RUN;
        $r['count'] = $r['time'];
      }
  }
  $r['count']--;
  $r['ticks']++;
}

function increment(&$reindeers) {
  foreach ($reindeers as &$r) {
    tick($r);
  }
}

function printResult($reindeers) {
  $max = 0;
  foreach ($reindeers as $name => $r) {
    printf("%s\t-> %d\n", $name, $r['distance']);
    $max = ($r['distance'] > $max) ? $r['distance'] : $max;
  }
  print("\nMax: ${max}\n");
}

for ($i=0;$i<1000;$i++) {
    increment($reindeers);
}
printResult($reindeers);
