<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return strlen($value) == 0; 
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    return (strlen($value) >= $options['min'] && strlen($value) <= $options['max']);
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL); 
  }

  function valid_symbols($value, $symbols=array()) {
    return ctype_alpha(str_replace($symbols, '', $value));
  }

  function valid_user($value) {
    return ctype_alnum(str_replace('_', '', $value));
  }

?>
