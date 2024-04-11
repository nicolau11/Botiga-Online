<?php
    session_start();
    if (!isset($_SESSION["usuariClient"])) {
        header('Location: login.php');
    }

?>

<?php
$conn = mysqli_connect("localhost", "root", "", "botiga2024");

echo "<div class='mostrarProductes'>";
echo "<form method='post'>";

$sql = "SELECT nom, descripcio, preu, stock, codiProducte FROM producte";
$query = mysqli_query($conn, $sql);

$codisProductes = array();

while ($fila = mysqli_fetch_assoc($query)) {
  echo "<h2>" . $fila['nom'] . "</h2>";
  echo "<p>Descripción: " . $fila['descripcio'] . "</p>";
  echo "<p>Precio: " . $fila['preu'] . "</p>";
  echo "<p>Stock: " . $fila['stock'] . "</p>";

  echo "<input type='hidden' name='codi' value='" . $fila['codiProducte'] . "'>";
  
  $codisProductes[] = $fila['codiProducte'];
  
  echo "<input type='submit' name='afegirCarrito[" . $fila['codiProducte'] . "]' value='Afegir Carrito'>";

  if (isset($_POST['afegirCarrito'][$fila['codiProducte']])) {
    $nom = $fila['nom'];
    $preu = $fila['preu'];
    $quantitat = 1;

    $_SESSION['carrito'][] = array(
      'codiProducte' => $fila['codiProducte'],
      'nom' => $nom,
      'preu' => $preu,
      'quantitat' => $quantitat,
    );
  }
}

echo "<input type='submit' name='anarCarrito' value='Carrito'>";

echo "</form>";
echo "</div>";


if (isset($_POST['anarCarrito'])) {
    header("Location: finalitzarcompra.php");
  }
?>

