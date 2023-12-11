<?php

  // prevent session fixation
  ini_set('session.use_only_cookies', 1);
  // make sure website only use session id which has been created by the website
  ini_set('session.use_strict_mode', 1);

  session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true,
  ]);

session_start();

// check if a session variable is created
if (!isset($_SESSION['last_regeneration'])) {
  // first time generating session
  session_regenerate_id(true);
  $_SESSION['last_regeneration'] = time();
} else {
  // regenerating session id every 30minutes
  $interval = 60 * 30;

  if (time() - $_SESSION['last_regeneration'] >= $interval) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
  }
}
