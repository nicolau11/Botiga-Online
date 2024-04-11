<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <section id="login">
        <div class="lg">
            <form method="post">
                <label for="usuari">Email:</label><br>
                <input type="text" name="usuari"><br>
                
                <label for="passwd">Contrasenya:</label><br>
                <input type="password" name="passwd"><br>
                <input type="submit" name="entrar" id="entrar" value="Entrar"><br>
            </form>
        </div>
        <div><form method="post"><input type="submit" id="registrat" name="registrat" value="REGISTRA'T"></form></div>
    </section>
</body>
</html>

<?php
    $conn = mysqli_connect("localhost", "root", "", "botiga2024");
    session_start();

    if (isset($_POST["entrar"])) {
        $email = $_POST["usuari"];
        $password = $_POST["passwd"];

        $hashClient = md5($password);

        $sqlAdmin = "SELECT email, password FROM usuari WHERE email = '$email' AND password = '$password' AND admin = 1";
        $sentenciaAdmin = mysqli_query($conn, $sqlAdmin);

        if ($sentenciaAdmin && mysqli_fetch_assoc($sentenciaAdmin)) {
            $_SESSION["admin"] = "admin";
            header("Location: adminProductes.php");
            exit();
        } else {
            $sqlUsuari = "SELECT email, password FROM usuari WHERE email = '$email' AND password = '$hashClient'";
            $sentenciaUsuari = mysqli_query($conn, $sqlUsuari);

            if ($sentenciaUsuari && mysqli_fetch_assoc($sentenciaUsuari)) {
                $_SESSION["usuariClient"] = "$email";
                header("Location: mostrarProductesClients.php");
                exit();
            } else {
                echo "Usuari o contrasenya incorrectes!";
            }
        }
    }

    if (isset($_POST["registrat"])) {
        header("Location: registre.php");
        exit();
    }

?>

