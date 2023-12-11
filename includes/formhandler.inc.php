<?php
// syntax: no closing tag for a pure php file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        // link to another file
        require_once "dbh.inc.php";

        // SQL prepared statement (named parameters)
        $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";

        $statement = $pdo->prepare($query);

        // hash password
        $pwdSignup = "123456";
        $options = [
            'cost' => 12
        ];
        $hashedPwd = password_hash($pwdSignup, PASSWORD_BCRYPT, $options);

        // bind named parameters
        $statement->bindParam(":username", $username);
        $statement->bindParam(":pwd", $hashedPwd);
        $statement->bindParam(":email", $email);

        // execute SQL query
        $statement->execute();

        // clean up after query
        $pdo = null;
        $statement = null;

        // redirect back to homepage
        header("Location: ../index.php");
        die();
    } catch (PDOException $e) {
        // terminate script with error message
        die("Query failed: " . $e->getMessage());
    }
} else {
    // redirect to homepage
    header("Location: ../index.php");
}
