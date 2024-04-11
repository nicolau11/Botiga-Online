<?php
    session_start();
    if (!$_SESSION["admin"]) {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productes</title>
</head>
<body>
    <header>
        <h1>Administrador</h1>
    </header>
    
    <section>
        <div>
            <h2>Afegir Productes</h2>

            <form method="post" enctype="multipart/form-data">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required><br>

                <label for="descripcio">Descripcio:</label>
                <textarea name="descripcio" id="descripcio" cols="30" rows="10" required></textarea><br>

                <label for="preu">Preu:</label>
                <input type="text" id="preu" name="preu" required><br>

                <label for="stock">Stock:</label>
                <input type="text" id="stock" name="stock" required><br>

                <label for='imatge'>Imatge:</label>
                <input type='file' id='imatge' name='imatge' required><br>

                <input type='submit' name='afegir' id="afegir" value='Afegir'>
            </form>

        </div>
    </section>
</body>
</html>

<?php
    $conn = mysqli_connect("localhost", "root", "", "botiga2024");

    if (isset($_POST["m"])) {
        $nomModificar = $_POST["nomModificar"];
        $descripModificar = $_POST["descripModificar"];
        $preuModificar = $_POST["preuModificar"];
        $stockModificar = $_POST["stockModificar"];
        $codi = $_POST["codi"];
    
        $sqlUpdate = "UPDATE noticia SET titol='$titolModificar', cos='$cosModificar' WHERE codiNoticia='$codi'";
        mysqli_query($conn, $sqlUpdate);
    }

    /* Crear Producte */
    if(isset($_POST["afegir"])) {
        $nom = $_POST["nom"];
        $descripcio = $_POST["descripcio"];
        $preu = $_POST["preu"];
        $stock = $_POST["stock"];

        $ruta = "./images/" . basename($_FILES["imatge"]["name"]);
        $tipus = pathinfo($ruta, PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["imatge"]["tmp_name"], $ruta);

        $sqlInserirProductes = "INSERT INTO producte (nom, descripcio, preu, stock, tipusImatge, nomImatge) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sqlInserirProductes);
        
        mysqli_stmt_bind_param($stmt, "ssdiss", $nom, $descripcio, $preu, $stock, $tipus, $ruta);

        if(mysqli_stmt_execute($stmt)) {
            echo "Producto agregado correctamente.";
        } else {
            echo "Error al agregar el producto: " . mysqli_error($conn);
        }
    }

    /* Eliminar Producte */
    echo "<div class='eliminar'>";
        echo "<form method='post'>";

        if (isset($_POST["eliminar"])) {
            $producteEliminar = $_POST["codi"];
            $sqlEliminar = "DELETE FROM producte WHERE codiProducte = $producteEliminar";

            if (mysqli_query($conn, $sqlEliminar)) {
                $sqlSeleccio = "SELECT nom, codiProducte FROM producte";
                $querySeleccio = mysqli_query($conn, $sqlSeleccio);

                while ($fila = mysqli_fetch_assoc($querySeleccio)) {
                    echo "<input name='codi' type='radio' value= '" . $fila['codiProducte'] . "'>" . $fila['nom'] . "<br>";
                }
            }
        } else {
            $sql = "SELECT nom, codiProducte FROM producte";
            $query = mysqli_query($conn, $sql);

            while ($fila = mysqli_fetch_assoc($query)) {
                echo "<input name='codi' type='radio' value= '" . $fila['codiProducte'] . "'>" . $fila['nom'] . "<br>";
            }
        }

        echo "<input type='submit' name='eliminar' value='Eliminar'>";
        echo "</form>";
        echo "</div>";

    /*Modificar Noticia */
    $sql = "SELECT nom, codiProducte FROM producte";
    $query = mysqli_query($conn, $sql);

    echo "<form action='' method='post'>
    <h3>Selecciona Nom:</h3>
    <select name='nom_seleccionat' id='nom_seleccionat'>";

    while ($fila = mysqli_fetch_assoc($query)) {
        echo "<option value='" . $fila['codiProducte'] . "'>" . $fila['nom'] . "</option>";
    }

    echo "<input type='submit' name='modificar' value='Modificar'>";
    echo "</select>
    </form>";

    if (isset($_POST['modificar'])) {
        if (isset($_POST['nom_seleccionat'])) {
            $sel = $_POST['nom_seleccionat'];

            $sqlSel = "SELECT codiProducte, nom, descripcio, preu, stock FROM producte WHERE codiProducte = '$sel'";
            $query = mysqli_query($conn, $sqlSel);
            $fila = mysqli_fetch_assoc($query);

            echo " <form action='' method='post'>";
            echo " <input type='hidden' name='codi' value='" . $fila["codiProducte"] . "'>";
            echo " <input type='text' name='nomModificar' value='" . $fila["nom"] . "'>";
            echo " <textarea name='descripModificar'>" . $fila["descripcio"] . "</textarea>";
            echo " <input type='text' name='preuModificar' value='" . $fila["preu"] . "'>";
            echo " <input type='text' name='stockModificar' value='" . $fila["stock"] . "'>";
            echo " <input type='submit' name='m' value='Modificar'>";
            echo " </form>";
        }
    }

?>

