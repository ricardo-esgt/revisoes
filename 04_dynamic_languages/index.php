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
            <label for="">Session ID</label>
            <input type="text" name="session_id">
        </div>
        <input type="submit" value="Submit" name="vulnerable">
    </form>

    <?php

        if(!empty($_POST["vulnerable"])) {

            $authenticationValidation = vulnerableAuthentication($_POST["session_id"]);

            echo $authenticationValidation == true ? "Authenticated" : $authenticationValidation; 
        }

        function vulnerableAuthentication($sessionId)
        {
            if($sessionId == "123") {
                return true;
            }

            return "Invalid Credentials";
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">Session ID</label>
            <input type="text" name="session_id">
        </div>
        <input type="submit" value="Submit" name="secure">
    </form>

    <?php

        if(!empty($_POST["secure"])) {

            $authenticationValidation = secureAuthentication($_POST["session_id"]);

            echo $authenticationValidation["valid"] == true ? "Authenticated" : $authenticationValidation["message"]; 
        }

        function secureAuthentication($sessionId): array
        {
            if($sessionId == "123") {
                return ["valid" => true, "message" => ""];
            }

            return ["valid" => false, "message" => "Invalid Credentials"];
        }
    ?>

</body>
</html>