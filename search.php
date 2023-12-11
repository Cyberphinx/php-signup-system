<?php
    // session security:
    // validate user data
    // don't store sensitive info in session variable
    // delete old session data

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $userSearch = $_POST["usersearch"];
    
        try {
            // link to another file
            require_once "includes/dbh.inc.php";
            
            // SQL prepared statement (named parameters)
            $query = "SELECT * FROM comments WHERE username = :usersearch;";
            $statement = $pdo->prepare($query);
            $statement->bindParam(":usersearch", $userSearch);
            
            $statement->execute();

            // fetch the data as associative array
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $pdo = null;
            $statement = null;
        } catch(PDOException $e){
            // terminate script with error message
            die("Query failed: " . $e->getMessage());
        }
    
    } else {
        // redirect to homepage
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Search results</title>
</head>
<body>
    <?php
        echo $_SESSION["username"];    
    ?>
    <section>
        <h3>Seach results: </h3>

        <?php

        if (empty($results)) {
            echo "<div>";
            echo "<p>There were no results!</p>";
            echo "</div>";
        } else {
            foreach ($results as $row) {
                echo "<div>";
                echo "<h4>" . htmlspecialchars($row["username"]) . "</h4>";
                echo "<p>" . htmlspecialchars($row["comments_text"]) . "</p>";
                echo "<p>" . htmlspecialchars($row["created_at"]) . "</p>";
                echo "</div>";
            }
        }

        ?>
    </section>
</body>
</html>
