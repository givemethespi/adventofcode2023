<?php
$input = file_get_contents('./7.txt');

function getSolution1($input) {
    $tab_figures = str_split('AKQT98765432J');

    $input_lines = explode("\n", $input);

    $tab_hands = [];
    foreach ($input_lines as $line) {
        if (!empty(trim($line))) {
            $tab_hands[] = explode(' ', $line);
        }
    }

    usort($tab_hands, function ($a, $b) use ($tab_figures) {
        $occs_a = count_chars($a[0], 1);
        $occs_b = count_chars($b[0], 1);
        if (count($occs_a) < count($occs_b)) {
            return 1;
        } elseif (count($occs_a) > count($occs_b)) {
            return -1;
        }

        $max_occ_a = 0;
        $max_occ_b = 0;
        foreach ($occs_a as $occ_a) {
            if ($occ_a > $max_occ_a) {
                $max_occ_a = $occ_a;
            }
        }
        foreach ($occs_b as $occ_b) {
            if ($occ_b > $max_occ_b) {
                $max_occ_b = $occ_b;
            }
        }
        if ($max_occ_a > $max_occ_b) {
            return 1;
        } elseif ($max_occ_a < $max_occ_b) {
            return -1;
        }

        // same figure
        $a = str_split($a[0]);
        $b = str_split($b[0]);
        for ($i = 0; $i < 5; $i++) {
            if ($a[$i] === $b[$i]) {
                continue;
            } else {
                if (
                    array_search($a[$i], $tab_figures) <
                    array_search($b[$i], $tab_figures)
                ) {
                    return 1;
                } else {
                    return -1;
                }
            }
        }

        return 0;
    });

    $sol = 0;
    for ($i = 0; $i < count($tab_hands); $i++) {
        $hand = $tab_hands[$i];
        $sol += ($i + 1) * intval($hand[1]);
    }

    return $sol;
}

function getSolution2($input) {
    $tab_figures = str_split('AKQT98765432J');

    $input_lines = explode("\n", $input);

    $tab_hands = [];
    foreach ($input_lines as $line) {
        if (!empty(trim($line))) {
            $tab_hands[] = explode(' ', $line);
        }
    }

    usort($tab_hands, function ($a, $b) use ($tab_figures) {
        $nb_joker_a = substr_count($a[0], 'J');
        $nb_joker_b = substr_count($b[0], 'J');
        $a_no_joker = str_replace('J', '', $a[0]);
        $b_no_joker = str_replace('J', '', $b[0]);
        if (strlen($a_no_joker) === 0) {
            $a_no_joker = 'JJJJJ';
            $nb_joker_a = 0;
        }
        if (strlen($b_no_joker) === 0) {
            $b_no_joker = 'JJJJJ';
            $nb_joker_b = 0;
        }
        $occs_a = count_chars($a_no_joker, 1);
        $occs_b = count_chars($b_no_joker, 1);
        sort($occs_a);
        sort($occs_b);
        $occs_a[count($occs_a) - 1] += $nb_joker_a;
        $occs_b[count($occs_b) - 1] += $nb_joker_b;
        if (count($occs_a) < count($occs_b)) {
            return 1;
        } elseif (count($occs_a) > count($occs_b)) {
            return -1;
        }

        $max_occ_a = 0;
        $max_occ_b = 0;
        foreach ($occs_a as $occ_a) {
            if ($occ_a > $max_occ_a) {
                $max_occ_a = $occ_a;
            }
        }
        foreach ($occs_b as $occ_b) {
            if ($occ_b > $max_occ_b) {
                $max_occ_b = $occ_b;
            }
        }
        if ($max_occ_a > $max_occ_b) {
            return 1;
        } elseif ($max_occ_a < $max_occ_b) {
            return -1;
        }

        // same figure
        $a = str_split($a[0]);
        $b = str_split($b[0]);
        for ($i = 0; $i < 5; $i++) {
            if ($a[$i] === $b[$i]) {
                continue;
            } else {
                if (
                    array_search($a[$i], $tab_figures) <
                    array_search($b[$i], $tab_figures)
                ) {
                    return 1;
                } else {
                    return -1;
                }
            }
        }

        return 0;
    });

    $sol = 0;
    for ($i = 0; $i < count($tab_hands); $i++) {
        $hand = $tab_hands[$i];
        $sol += ($i + 1) * intval($hand[1]);
    }

    return $sol;
}

echo 'Solution part 1 : ' . getSolution1($input) . PHP_EOL;
echo 'Solution part 2 : ' . getSolution2($input) . PHP_EOL;
