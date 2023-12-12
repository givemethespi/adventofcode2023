<?php
$input = file_get_contents('./6.txt');

function getDistance($time, $max_time) {
    return ($max_time - $time) * $time;
}

function getSolution1($input) {
    $input_lines = explode("\n", $input);

    $times = str_replace('Time:', '', $input_lines[0]);
    preg_match_all('/\s*(\d+)\s*/', $times, $matches);
    $times = array_map(function ($a) {
        return intval($a);
    }, $matches[1]);

    $distances = str_replace('Distance:', '', $input_lines[1]);
    preg_match_all('/\s*(\d+)\s*/', $distances, $matches);
    $distances = array_map(function ($a) {
        return intval($a);
    }, $matches[1]);

    $sol = 1;

    for ($i = 0; $i < count($times); $i++) {
        $cursor = floor($times[$i] / 2);
        $nb_wins = 0;
        if (getDistance($cursor, $times[$i]) > $distances[$i]) {
            while (
                $cursor >= 0 &&
                getDistance($cursor, $times[$i]) > $distances[$i]
            ) {
                $nb_wins += 2;
                $cursor--;
            }

            if ($times[$i] % 2 === 0) {
                $nb_wins--;
            }
        }
        $sol *= $nb_wins;
    }

    return $sol;
}

function getSolution2($input) {
    $input_lines = explode("\n", $input);

    $time = intval(
        preg_replace('/\s*/', '', str_replace('Time:', '', $input_lines[0]))
    );

    $distance = intval(
        preg_replace('/\s*/', '', str_replace('Distance:', '', $input_lines[1]))
    );

    $cursor = floor($time / 2);
    $nb_wins = 0;
    if (getDistance($cursor, $time) > $distance) {
        while ($cursor >= 0 && getDistance($cursor, $time) > $distance) {
            $nb_wins += 2;
            $cursor--;
        }

        if ($time % 2 === 0) {
            $nb_wins--;
        }
    }

    return $nb_wins;
}

echo 'Solution part 1 : ' . getSolution1($input) . PHP_EOL;
echo 'Solution part 2 : ' . getSolution2($input) . PHP_EOL;
