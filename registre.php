<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
</head>
<body>
    <section>
        <div>
            <form method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">

                <label for="passwd">Contrasenya:</label>
                <input type="password" id="passwd" name="passwd">

                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom">

                <label for="cognoms">Cognoms:</label>
                <input type="text" id="cognoms" name="cognoms">

                <label for="direccio">Direcció:</label>
                <input type="text" id="direccio" name="direccio">

                <label for="poblacio">Població:</label>
                <input type="text" id="poblacio" name="poblacio">

                <label for="cpostal">Codi Postal:</label>
                <input type="number" id="cpostal" name="cpostal">

                <input type="submit" id="registrar" name="registrar" value="Registrar">
            </form>
        </div>
    </section>
</body>
</html>

<?php
    $conn = mysqli_connect("localhost", "root", "", "botiga2024");

    if (isset($_POST["registrar"])) {
        $email = $_POST["email"];
        $passwd = $_POST["passwd"];
        $nom = $_POST["nom"];
        $cognoms = $_POST["cognoms"];
        $direccio = $_POST["direccio"];
        $poblacio = $_POST["poblacio"];
        $cpostal = $_POST["cpostal"];

        $hashClient = md5($passwd);

        $sqlInserir = "INSERT INTO usuari (email, password, nom, cognoms, direccio, poblacio, cPostal) VALUES ('$email', '$hashClient', '$nom', '$cognoms', '$direccio', '$poblacio', '$cpostal')";

        mysqli_query($conn, $sqlInserir);
    }
?>