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
            <input type="submit" value="Submit" name="vulnerable">
        </div>
    </form>

    <?php

        if(!empty($_POST["vulnerable"])) {

            $host = "postgres";

            $schema = "revisoes";

            $user = "default";

            $pass = "secret";

            $username = $_POST["username"];

            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$schema;user=$user;password=$pass");
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //Query exposta a SQL Injection
            //estamos a concatenar diretamente os inputs a query
            //e possivel injetar comandos SQL e manipular a BD com CRUD
            $data = $conn->query("SELECT name FROM users WHERE username = '$username'");

            foreach ($data->fetchAll() as $user) {

                $name = $user["name"];

                echo "<pre>$name</pre>";
            }
            
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">Username</label>
            <input type="text" name="username">
            <input type="submit" value="Submit" name="secure">
        </div>
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

            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$schema;user=$user;password=$pass");
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Executamos uma parameterized query que trata os comandos SQL dos inputs
            //como string e nao SQL executavel
            //previne SQL Injection
            $parameterizedQuery = $conn->prepare("SELECT name FROM users WHERE username=:username");

            $parameterizedQuery->bindParam(":username", $username, PDO::PARAM_STR);

            $parameterizedQuery->execute();

            foreach ($parameterizedQuery->fetchAll() as $user) {

                $name = $user["name"];

                echo "<pre>$name</pre>";
            }
            
        }
    ?>
</body>
</html>