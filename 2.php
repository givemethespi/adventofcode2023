<?php
$input = file_get_contents('./2.txt');

const MAX_RED = 12;
const MAX_GREEN = 13;
const MAX_BLUE = 14;

function getSolution1($input) {
    $input_lines = explode("\n", $input);

    $sum = 0;

    foreach ($input_lines as $line) {
        $line = explode(':', $line);
        $game_id = intval(str_replace('Game ', '', $line[0]));
        $grabs = explode(';', $line[1]);
        $possible = true;
        foreach ($grabs as $grab) {
            $grab = explode(',', $grab);
            $colors = ['green' => 0, 'red' => 0, 'blue' => 0];
            foreach ($grab as $color) {
                $color = trim($color);
                if (preg_match('/(\d+)\s(blue|green|red)/', $color, $matches)) {
                    $colors[$matches[2]] += intval($matches[1]);
                }
            }
            if (
                $colors['green'] > MAX_GREEN ||
                $colors['red'] > MAX_RED ||
                $colors['blue'] > MAX_BLUE
            ) {
                $possible = false;
                break;
            }
        }
        if ($possible) {
            $sum += $game_id;
        }
    }

    return $sum;
}

function getSolution2($input) {
    $input_lines = explode("\n", $input);

    $sum = 0;

    foreach ($input_lines as $line) {
        $line = explode(':', $line);
        $grabs = explode(';', $line[1]);
        $colors = ['green' => 0, 'red' => 0, 'blue' => 0];
        foreach ($grabs as $grab) {
            $grab = explode(',', $grab);
            foreach ($grab as $color) {
                $color = trim($color);
                if (preg_match('/(\d+)\s(blue|green|red)/', $color, $matches)) {
                    if (intval($matches[1]) > $colors[$matches[2]]) {
                        $colors[$matches[2]] = intval($matches[1]);
                    }
                }
            }
        }
        $power = $colors['green'] * $colors['red'] * $colors['blue'];
        $sum += $power;
    }

    return $sum;
}

echo 'Solution part 1 : ' . getSolution1($input) . PHP_EOL;
echo 'Solution part 2 : ' . getSolution2($input) . PHP_EOL;
