<?php
$input = file_get_contents('./4.txt');

function getNbWinners($line) {
    $line = preg_replace('/Card \d+:\s+/', '', $line);
    $line = explode(' | ', $line);
    $winners = preg_split('/\s+/', $line[0]);
    $numbers = preg_split('/\s+/', $line[1]);

    $numbers_in_winners = array_intersect($winners, $numbers);

    return count($numbers_in_winners);
}

function getSolution1($input) {
    $input_lines = explode("\n", $input);

    $sum = 0;
    foreach ($input_lines as $line) {
        $points = 0;
        $nbWinners = getNbWinners($line);
        if ($nbWinners > 0) {
            $points = pow(2, $nbWinners - 1);
        }

        $sum += $points;
    }

    return $sum;
}

function getSolution2($input) {
    $scratchcards = explode("\n", $input);

    $scratchcards_by_cardnumber = [];
    foreach ($scratchcards as $card) {
        preg_match('/Card\s+(\d+):/', $card, $matches);
        $num_card = intval($matches[1]);

        $nbWinners = getNbWinners($card);
        $scratchcards_by_cardnumber[$num_card] = $nbWinners;
    }

    $scratchcards_copy = [];
    foreach ($scratchcards_by_cardnumber as $num_card => $nbWinners) {
        if (empty($scratchcards_copy[$num_card])) {
            $scratchcards_copy[$num_card] = [$nbWinners];
        } else {
            $scratchcards_copy[$num_card][] = $nbWinners;
        }
        foreach ($scratchcards_copy[$num_card] as $nbToCopy) {
            for ($i = 1; $i <= $nbToCopy; $i++) {
                if (empty($scratchcards_copy[$num_card + $i])) {
                    $scratchcards_copy[$num_card + $i] = [
                        $scratchcards_by_cardnumber[$num_card + $i],
                    ];
                } else {
                    $scratchcards_copy[$num_card + $i][] =
                        $scratchcards_by_cardnumber[$num_card + $i];
                }
            }
        }
    }

    $sum = 0;
    foreach ($scratchcards_copy as $card) {
        $sum += count($card);
    }

    return $sum;
}

echo 'Solution part 1 : ' . getSolution1($input) . PHP_EOL;
echo 'Solution part 2 : ' . getSolution2($input) . PHP_EOL;
