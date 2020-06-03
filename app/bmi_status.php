<?php

function bmi_status(float $bmi) {
  if ($bmi < 18.5) {
    return 'Underweight';
  } else if ($bmi < 25) {
    return 'Normal weight';
  } else if ($bmi < 30) {
    return 'Pre-obesity';
  } else if ($bmi < 35) {
    return 'Obesity class I';
  } else if ($bmi < 40) {
    return 'Obesity class II';
  }
  return 'Obesity class III';
};
