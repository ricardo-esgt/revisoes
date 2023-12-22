<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>00 - Command Execution</title>
</head>
<body>
    <a href="../">Voltar</a>
    <form action="." method="post">
        <h1>Vulnerable</h1>
        <div>
            <label for="">IP</label>
            <input type="text" name="ip">
            <input type="submit" value="Submit" name="vulnerable">
        </div>
    </form>

    <?php

        if(!empty($_POST["vulnerable"])) {

            $ip = $_POST["ip"];
            //e possivel executar comandos do OS
            //se passarmos o comando "ls"
            //vai retornar a lista de ficheiros
            //conseguimos fazer reverse shell e ter acesso direto ao OS
            echo "<pre>" . shell_exec("ping -c 4 $ip") . "</pre>";
            
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">IP</label>
            <input type="text" name="ip">
            <input type="submit" value="Submit" name="secure">
        </div>
    </form>

    <?php
        
        if(!empty($_POST["secure"])) {

            $ip = $_POST["ip"];

            //como queremos executar um ping
            //validamos se o input passado e um IP e nao outra coisa que possa executar no OS
            if(filter_var($ip, FILTER_VALIDATE_IP)) {
                echo "<pre>" . shell_exec("ping -c 4 $ip") . "</pre>";

                exit;
            }

            
            echo "<pre>Invalid IP</pre>";
            
        }
    ?>
</body>
</html>