<?php
$input = file_get_contents('./3.txt');

function isAdjacentToSymbol($number, $line, $col, $tab_input) {
    $found = false;
    for ($i = $line - 1; $i <= $line + 1; $i++) {
        for ($j = $col - strlen(strval($number)); $j <= $col + 1; $j++) {
            if (
                !empty($tab_input[$i][$j]) &&
                !is_numeric($tab_input[$i][$j]) &&
                $tab_input[$i][$j] !== '.'
            ) {
                $found = true;
                break;
            }
        }
        if ($found) {
            break;
        }
    }
    return $found;
}

function getCloseNumbers($line, $col, $tab_input) {
    $tab_close = [];
    $number = '';
    for ($i = $line - 1; $i <= $line + 1; $i++) {
        for ($j = $col - 1; $j <= $col + 1; $j++) {
            if (is_numeric($tab_input[$i][$j])) {
                $number .= $tab_input[$i][$j];
                // first col get numbers before
                if ($j === $col - 1) {
                    $k = $col - 2;
                    while (
                        isset($tab_input[$i][$k]) &&
                        is_numeric($tab_input[$i][$k])
                    ) {
                        $number = $tab_input[$i][$k] . $number;
                        $k--;
                    }
                }
                // last col get numbers after
                elseif ($j === $col + 1) {
                    $k = $col + 2;
                    while (
                        isset($tab_input[$i][$k]) &&
                        is_numeric($tab_input[$i][$k])
                    ) {
                        $number .= $tab_input[$i][$k];
                        $k++;
                    }
                    $tab_close[] = intval($number);
                    $number = '';
                }
                if (
                    $j !== $col + 1 &&
                    (!isset($tab_input[$i][$j + 1]) ||
                        !is_numeric($tab_input[$i][$j + 1]))
                ) {
                    $tab_close[] = intval($number);
                    $number = '';
                }
            }
        }
    }
    return $tab_close;
}

function getSolution1($input) {
    $input_lines = explode("\n", $input);

    $tab_input = [];
    foreach ($input_lines as $line) {
        $tab_input[] = str_split($line);
    }

    $number = '';
    $tab_adjacent = [];
    for ($i = 0; $i < count($tab_input); $i++) {
        $line = $tab_input[$i];
        for ($j = 0; $j < count($line); $j++) {
            $char = $line[$j];
            if (is_numeric($char)) {
                $number .= $char;
                if (
                    !isset($tab_input[$i][$j + 1]) ||
                    !is_numeric($tab_input[$i][$j + 1])
                ) {
                    $number = intval($number);
                    if (isAdjacentToSymbol($number, $i, $j, $tab_input)) {
                        $tab_adjacent[] = $number;
                    }
                    $number = '';
                }
            }
        }
    }

    return array_sum($tab_adjacent);
}

function getSolution2($input) {
    $input_lines = explode("\n", $input);

    $tab_input = [];
    foreach ($input_lines as $line) {
        $tab_input[] = str_split($line);
    }

    $sum = 0;

    for ($i = 0; $i < count($tab_input); $i++) {
        $line = $tab_input[$i];
        for ($j = 0; $j < count($line); $j++) {
            $char = $line[$j];
            if ($char === '*') {
                $tab_numbers = getCloseNumbers($i, $j, $tab_input);
                if (count($tab_numbers) === 2) {
                    $sum += $tab_numbers[0] * $tab_numbers[1];
                }
            }
        }
    }

    return $sum;
}

echo 'Solution part 1 : ' . getSolution1($input) . PHP_EOL;
echo 'Solution part 2 : ' . getSolution2($input) . PHP_EOL;
