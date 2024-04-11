<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "botiga2024");

    if (!isset($_SESSION['carrito'])) {
      echo "<p>El carrito esta buit.</p>";
    } else {
      echo "<h2>Carrito de compra</h2>";
      echo "<ul>";

      foreach ($_SESSION['carrito'] as $producto) {
        echo "<li>" . $producto['nom'] . " - " . $producto['preu'] . "€ - " . $producto['quantitat'] . "</li>";
      }

      echo "</ul>";
      
      $total = 0;
      foreach ($_SESSION['carrito'] as $producto) {
        $total += $producto['preu'] * $producto['quantitat'];
      }

      echo "<p>Total: " . $total . "€</p>";
    }

    echo "<form method='post'>";
    echo "<input type='submit' name='pagament' value='Pagament'>";

    if (isset($_POST["pagament"])) {  
      $email = $_SESSION["usuariClient"];
      $dataCompra = date("Y-m-d");

      $sqlCompra = "INSERT INTO compra (data, email) VALUES ('$dataCompra', '$email')";
      mysqli_query($conn, $sqlCompra);
  }
    
?>