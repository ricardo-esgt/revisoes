<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>04 - Dynamic Languages</title>
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
            //funcao retorna boolean ou string
            $authenticationValidation = vulnerableAuthentication($_POST["session_id"]);

            //linguagens dinamicas funcionam com tipos falsy: false, 0, "0", "", []
            //como a funcao retorna true para sucesso e string para mensagem de erro,
            //esta validacao avalia para true, uma string vazia converte para true
            //assim e possivel fazer bypass a esta validacao
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
            //esta funcao retorna sempre o mesmo tipo
            //array associativo e cada chave retorna um valor do mesmo tipo
            $authenticationValidation = secureAuthentication($_POST["session_id"]);

            //avaliamos a chave valid que e boolean e no caso de erro, retornamos a mensagem de erro
            //nao conseguimos fazer bypass
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