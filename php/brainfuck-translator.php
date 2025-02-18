<?php
ini_set('memory_limit', '600M');

function brainfuck_to_c($source_code) {
  // Remove any non-bf character
  $source = preg_replace('/[^\+\-\<\>\,\.\[\]]/', '', $source_code);
  
  $bf = optimize_bf($source);
  if ($bf === "Error!" || $bf === "") {
    return $bf;
  }
  
  $res = "";
  $counter = 0;
  $indent = 0;
  $cur = "";
  foreach($bf as $char) {
    switch ($char) {
      case "+":
      case "-":
      case ">":
      case "<":
        if ($cur === "") {
          $cur = $char;
        }
        
        if ($cur !== $char) {
          $res .= math_instruction($indent, $cur, $counter);
          $counter = 0;
          $cur = $char;
        }
        
        $counter++;
        break;
      
      case ".":
        if ($counter > 0) {
          $res .= math_instruction($indent, $cur, $counter);
          $counter = 0;
          $cur = "";
        }
        $res .= str_repeat(" ", $indent) . "putchar(*p);\n";
        break;
      case ",":
        if ($counter > 0) {
          $res .= math_instruction($indent, $cur, $counter);
          $counter = 0;
          $cur = "";
        }
        $res .= str_repeat(" ", $indent) . "*p = getchar();\n";
        break;
      case "[":
        if ($counter > 0) {
          $res .= math_instruction($indent, $cur, $counter);
          $counter = 0;
          $cur = "";
        }
        $res .= str_repeat(" ", $indent) . "if (*p) do {\n";
        $indent += 2;
        break;
      case "]":
        if ($counter > 0) {
          $res .= math_instruction($indent, $cur, $counter);
          $counter = 0;
          $cur = "";
        }
        $indent -= 2;
        $res .= str_repeat(" ", $indent) . "} while (*p);\n";
        break;
    }
  }
  
  // Remainder, if counter still has something in it
  if ($counter > 0) {
    $res .= math_instruction($indent, $cur, $counter);
  }
  
  
  return $res;
}

function math_instruction($indent, $char, $counter) {
  $p = str_repeat(" ", $indent) . "";
  if ($char === "+" || $char === "-") {
    $p .= "*";
  }
  $p .= "p ";
  $p .= $char === "+" || $char === ">" ? "+" : "-";
  $p .= "= $counter;\n";
  return $p;
}

function optimize_bf($code) {
  $first = substr($code, 0, 1);
  $code = substr($code, 1);
  $code = str_split($code);
  if ($first === "]") {
    return "Error!";
  }
  $braceStack = $first === "[" ? 1 : 0;
  $optimized = [$first];
  
  foreach ($code as $char) {
    switch(true) {
      case $char === "]" && end($optimized) === "[":
        $braceStack--;
      case $char === "+" && end($optimized) === "-":
      case $char === "-" && end($optimized) === "+":
      case $char === "<" && end($optimized) === ">":
      case $char === ">" && end($optimized) === "<":
        array_pop($optimized);
        break;
        
      case $char === "." && end($optimized) === ".":
      case $char === "," && end($optimized) === ",":
        continue; // do nothing
      default:
        array_push($optimized, $char);
        if ($char === "[") {
          $braceStack++;
        }
        
        if ($char === "]") {
          $braceStack--;
          if ($braceStack < 0) { 
            return "Error!";
          }
        }
    }
  }

  return $braceStack !== 0 ? "Error!" : $optimized;
}
