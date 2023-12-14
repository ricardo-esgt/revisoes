<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>02 - SQL Injection</title>
</head>
<body>
    <a href="../">Voltar</a>
    <form action="." method="post">
        <h1>Vulnerable</h1>
        <div>
            <label for="">Username</label>
            <input type="text" name="username">
        </div>
        <div>
            <label for="">Password</label>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Submit" name="vulnerable">
    </form>

    <?php

        if(!empty($_POST["vulnerable"])) {

            $host = "postgres";

            $schema = "revisoes";

            $user = "default";

            $pass = "secret";

            $username = $_POST["username"];

            $password = $_POST["password"];

            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$schema;user=$user;password=$pass");
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $data = $conn->query("SELECT name FROM users WHERE username = '$username' and password_vulnerable = '$password'");

            if(empty($data->fetchAll()[0])) {
                echo "Invalid credentials";
            }
            
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">Username</label>
            <input type="text" name="username">
        </div>
        <div>
            <label for="">Password</label>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Submit" name="secure">
    </form>

    <?php

        if(!empty($_POST["secure"])) {

            require("./config.php");

            $creds = getCreds();

            $host = $creds["host"];

            $schema = $creds["schema"];

            $user = $creds["username"];

            $pass = $creds["password"];

            $username = $_POST["username"];

            $password = hash("SHA512", $_POST["password"]);

            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$schema;user=$user;password=$pass");
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $parameterizedQuery = $conn->prepare("SELECT name FROM users WHERE username=:username AND password_secure = :password");

            $parameterizedQuery->bindParam(":username", $username, PDO::PARAM_STR);

            $parameterizedQuery->bindParam(":password", $password, PDO::PARAM_STR);

            $parameterizedQuery->execute();

            if(empty($parameterizedQuery->fetchAll()[0])) {
                echo "Invalid credentials";
            }
            
        }
    ?>

</body>
</html>