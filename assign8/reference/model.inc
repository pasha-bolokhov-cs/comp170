<?php
//Model Module
  function random($number, $na) {
// Create the output array
    for ($i = 1; $i <= $number; $i++) {
      $randoms['random_'.$i] = rand();
    }
    $list['name']     = "RandomNumbers";
    $list['outTitle'] = "Output";
    $list['outValue'] = $randoms;

// Create the input array
    $list['inTitle']  = "Input";
    $list['inValue']['in_1']  = $number;
    $list['inValue']['N/A']  = $na;

// Return the array
    return $list;
  }
?>
