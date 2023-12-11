<?php
// mandatory setup for session security
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true,
]);

session_start();

// check if logged in
if (isset($_SESSION["user_id"])) {
    // if logged in
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedin();
    } else {
        // regenerate session id every 30 minutes
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }
    }
} else {
    // if not logged in
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        // regenerate session id every 30 minutes
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id_loggedin()
{
    // regenerate session id and delete old session id
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];
    // create a new session id for security, and append user id to it
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    // assign session id
    session_id($sessionId);

    // reset timer
    $_SESSION["last_regeneration"] = time();
}
