<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>06 - Path Traversal</title>
</head>
<body>
    <a href="../">Voltar</a>
    <form action="." method="post">
        <h1>Vulnerable</h1>
        <div>
            <label for="">Filename</label>
            <input type="text" name="filename">
        </div>
        <input type="submit" value="Download" name="vulnerable">
    </form>

    <?php
        // se passarmos teste.txt retorna o conteudo do txt
        // se passarmos ../path_traversal.txt retorna o conteudo de um txt exposto a path traversal
        if(!empty($_POST["vulnerable"])) {

            $filename = $_POST["filename"];

            if(!empty($filename)) {
                
                echo file_get_contents($filename);
            }  
        }
    ?>

    <form action="." method="post">
        <h1>Secure</h1>
        <div>
            <label for="">Filename</label>
            <input type="text" name="filename">
        </div>
        <input type="submit" value="Download" name="secure">
    </form>

    <?php

        if(!empty($_POST["secure"])) {
            // tratamento php para evitar path traversal
            // se passarmos caminhos, os mesmos serão removidos
            $filename = basename(realpath($_POST["filename"]));

            echo @file_get_contents($filename);  
        }
    ?>

</body>
</html>