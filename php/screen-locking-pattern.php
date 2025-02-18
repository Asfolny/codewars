function countPatternsFrom($f, $l) {
    if ($l < 1 || $l > 9) {
        return 0;
    }

    if ($l == 1) {
        return 1;
    }

    $patterns = [$f];

    while (strlen(current($patterns)) < $l) {
        foreach($patterns as $key => $pattern) {
            $used = substr($pattern, 0, -1);
            $last = $pattern[-1];
            $nexts = findNexts($last, str_split($used));
            foreach($nexts as $next) {
                $patterns[] = "{$used}{$last}{$next}";
            }
            unset($patterns[$key]);
        }
    }

    return count($patterns);
}

function findNexts($point, $seen) {
    switch($point) {
        case 'A':
            $candid = ['D', 'H', 'E', 'F', 'B'];
            $n = array_diff($candid, $seen);
            if ($n != $candid) {
                if (!in_array('B', $n) && !in_array('C', $seen)) {
                    $n[] = 'C';
                }

                if (!in_array('D', $n) && !in_array('G', $seen)) {
                    $n[] = 'G';
                }

                if (!in_array('E', $n) && !in_array('I', $seen)) {
                    $n[] = 'I';
                }
            }

            return $n;

        case 'B':
            $candid = ['A', 'D', 'G', 'E', 'I', 'F', 'C'];
            $n = array_diff($candid, $seen);

            if ($n != $candid && !in_array('E', $n) && !in_array('H', $seen)) {
                $n[] = 'H';
            }

            return $n;

        case 'C':
            $candid = ['B', 'D', 'E', 'H', 'F'];
            $n = array_diff($candid, $seen);
            if ($n != $candid) {
                if (!in_array('B', $n) && !in_array('A', $seen)) {
                    $n[] = 'A';
                }

                if (!in_array('F', $n) && !in_array('I', $seen)) {
                    $n[] = 'I';
                }

                if (!in_array('E', $n) && !in_array('G', $seen)) {
                    $n[] = 'G';
                }
            }

            return $n;

        case 'D':
            $candid = ['A', 'B', 'C', 'E', 'I', 'H', 'G'];
            $n = array_diff($candid, $seen);

            if ($n != $candid && !in_array('E', $n) && !in_array('F', $seen)) {
                $n[] = 'F';
            }

            return $n;

        case 'E':
            $candid = ['A', 'B', 'C', 'D', 'F', 'G', 'H', 'I'];
            $n = array_diff($candid, $seen);
            return $n;

        case 'F':
            $candid = ['A', 'B', 'C', 'E', 'G', 'H', 'I'];
            $n = array_diff($candid, $seen);

            if ($n != $candid && !in_array('E', $n) && !in_array('D', $seen)) {
                $n[] = 'D';
            }

            return $n;

        case 'G':
            $candid = ['D', 'B', 'E', 'F', 'H'];
            $n = array_diff($candid, $seen);
            if ($n != $candid) {
                if (!in_array('D', $n) && !in_array('A', $seen)) {
                    $n[] = 'A';
                }

                if (!in_array('H', $n) && !in_array('I', $seen)) {
                    $n[] = 'I';
                }

                if (!in_array('E', $n) && !in_array('C', $seen)) {
                    $n[] = 'C';
                }
            }

            return $n;

        case 'H':
            $candid = ['A', 'C', 'D', 'E', 'F', 'G', 'I'];
            $n = array_diff($candid, $seen);

            if ($n != $candid && !in_array('E', $n) && !in_array('B', $seen)) {
                $n[] = 'B';
            }

            return $n;

        case 'I':
            $candid = ['H', 'D', 'E', 'B', 'F'];
            $n = array_diff($candid, $seen);
            if ($n != $candid) {
                if (!in_array('F', $n) && !in_array('C', $seen)) {
                    $n[] = 'C';
                }

                if (!in_array('H', $n) && !in_array('G', $seen)) {
                    $n[] = 'G';
                }

                if (!in_array('E', $n) && !in_array('A', $seen)) {
                    $n[] = 'A';
                }
            }

            return $n;
    }

    return [];
}
