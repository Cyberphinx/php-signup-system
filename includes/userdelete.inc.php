<?php
// syntax: no closing tag for a pure php file

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        // link to another file
        require_once "dbh.inc.php";
        
        // SQL prepared statement (named parameters)
        $query = "DELETE FROM users WHERE username = :username AND pwd = :pwd;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":pwd", $pwd);

        
        $statement->execute();
        
        $pdo = null;
        $statement = null;
        // redirect back to homepage
        header("Location: ../index.php");
        die();
    } catch(PDOException $e){
        // terminate script with error message
        die("Query failed: " . $e->getMessage());
    }

} else {
    // redirect to homepage
    header("Location: ../index.php");
}
