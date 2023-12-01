<?php
$input = file_get_contents('./1.txt');

// Answer 1
$input_lines = explode("\n", $input);

$sum1 = 0;

foreach ($input_lines as $line) {
    $nb = preg_replace('/\D/', '', $line);
    $nb = intval($nb[0] . $nb[strlen($nb) - 1]);

    $sum1 += $nb;
}

// Answer 2
$tab_digits = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

foreach ($tab_digits as $key => $val) {
    $digit_split = str_split($key);
    $input = str_replace(
        $key,
        $digit_split[0] . $val . $digit_split[count($digit_split) - 1],
        $input
    );
}

$input_lines = explode("\n", $input);

$sum2 = 0;

foreach ($input_lines as $line) {
    $nb = preg_replace('/\D/', '', $line);
    $nb = intval($nb[0] . $nb[strlen($nb) - 1]);

    $sum2 += $nb;
}

// Answer 1
var_dump($sum1);

// Answer 2
var_dump($sum2);
