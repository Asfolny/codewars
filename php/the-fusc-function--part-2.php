<?php
function fusc(int $n): int {
  if ($n == 0) {
    return 0;
  }
  
  $a = 1;
  $b = 0;
  
  while ($n > 0) {
    if ($n % 2) {
      $b += $a;
      $n = ($n - 1) / 2;
    } else {
      $a += $b;
      $n = $n / 2;
    }
  }
  
  return $b;
}
