<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        // fetch data
        $result = get_user($pdo, $username);

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if (!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        // start session
        require_once 'config_session.inc.php';

        if ($errors) {
            // set errors in session storage
            $_SESSION["errors_login"] = $errors;

            // redirect back to homepage
            header("Location: ../index.php");

            // exit script function
            die();
        }

        // create a new session id for security, and append user id to it
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        // assign session id
        session_id($sessionId);

        // save user id & username to session storage
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);

        // reset timer
        $_SESSION["last_regeneration"] = time();

        // redirect to homepage with login success message
        header("Location: ../index.php?login=success");

        // best practice is to close off the database connection
        $pdo = null;
        $stmt = null;

        // terminating the script at this point
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}
