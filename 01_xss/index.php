<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>01 - XSS</title>
</head>
<body>
    <a href="../">Voltar</a>
    <form action="." method="post">
        <h1>Vulnerable</h1>
        <div>
            <label for="">Name</label>
            <input type="text" name="name">
            <input type="submit" value="Submit" name="vulnerable">
        </div>
    </form>

    <?php

        if(!empty($_POST["vulnerable"])) {

            $name = $_POST["name"];
            //renderiza diretamente o input do utilizador
            //e possivel injetar JS e PHP
            //com isto podemos fazer website defacing, roubo de cookies vulneraveis
            //key logging
            echo "<pre>$name</pre>";
            
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">Name</label>
            <input type="text" name="name">
            <input type="submit" value="Submit" name="secure">
        </div>
    </form>

    <?php

        if(!empty($_POST["secure"])) {

            //removemos todas as tags PHP e JS
            //nao vai executar scripts e assim removemos a capacidade de XSS
            $name = strip_tags($_POST["name"]);

            echo "<pre>$name</pre>";
            
        }
    ?>
</body>
</html>