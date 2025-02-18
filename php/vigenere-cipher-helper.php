<?php
class VigenèreCipher {
  public function __construct(
    private string $key,
    private string $alpha
  ) {}

  public function encode(string $s): string {
    $encoded = "";
    // This may take up more storage than absolutely necessary
    // A better approach is to ceil(len($key) / len($s)) and use a nested for loop
    $key = strlen($this->key) <= strlen($s) ? 
      str_pad($this->key, strlen($s), $this->key) :
      substr($this->key, 0, strlen($s));
    
    foreach(mb_str_split($s) as $index => $char) {
      if (!str_contains($this->alpha, $char)) {
        $encoded .= $char;
        continue;
      }
      
      $caesar = $key[$index];
      $shift = strpos($this->alpha, $caesar);
      $cur = strpos($this->alpha, $char);
      $new = $this->alpha[($cur + $shift) % strlen($this->alpha)];
      $encoded .= $new;
    }
    
    return $encoded;
  }

  public function decode(string $s): string {
    $decoded = "";
    // This may take up more storage than absolutely necessary
    // A better approach is to ceil(len($key) / len($s)) and use a nested for loop
    $key = strlen($this->key) <= strlen($s) ? 
      str_pad($this->key, strlen($s), $this->key) :
      substr($this->key, 0, strlen($s));
    
    foreach(mb_str_split($s) as $index => $char) {
      if (!str_contains($this->alpha, $char)) {
        $decoded .= $char;
        continue;
      }
      
      $caesar = $key[$index];
      $shift = strpos($this->alpha, $caesar);
      $cur = strpos($this->alpha, $char);
      
      $decIndex = ($cur - $shift) % strlen($this->alpha);
      $decIndex = $decIndex < 0 ? $decIndex + strlen($this->alpha) : $decIndex;
      
      $new = $this->alpha[$decIndex];
      $decoded .= $new;
    }
    
    return $decoded;
  }
}
