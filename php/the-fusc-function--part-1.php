<?php
function fusc(int $n): int {
  if ($n < 2) {
    return $n;
  }

  return $n % 2 === 0 ? fusc($n / 2) : fusc(($n-1) / 2) + fusc((($n-1)/2) + 1);
}
