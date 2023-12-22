<?php
    //COOKIE de sessao sem httponly e sem https, pode ser acedido via JS,
    //exposto a scripts que executem do lado cliente de forma maliciosa
    setcookie("VULNERABLE_SESSION_COOKIE", 123);

    //COOKIE de sessao com httponly e sem https
    //apenas são repassados nos pedidos http(s), JS não tem acesso
    setcookie("SECURE_SESSION_COOKIE", 1234566789, 0, "/", "", true, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>07 - Weak Cookie Configuration</title>
</head>
<body>
    <a href="../">Voltar</a>
    <h1>Cookies</h1>
    <p id="cookies"></p>
<script>
    //IMPRIME COOKIES
    let element = document.getElementById("cookies");

    element.innerText = document.cookie;
</script>
</body>
</html>