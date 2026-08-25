<?php 
try {
  $idMedicamento = 0;
  $nomMedicamento = "";
  $stockApartado = 0;
  $stockTotal = 0;
  $stockDisponible = 0;
  $imagen = "";
  $idUnidadMedida = "";
  $nomUnidadMedida = "";
  $cantidadActualPorEnvase = 0;
  $cantidadMaximaPorEnvase = 0;
  $idMedicamentoCategoria = 0;
  $idCategoria = 0;
  $nomCategoria = "";

  $idGET = 0;
  $modoGET = "";

  
  // Conecta con la base de datos
  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  if (isset($_GET['idMed']) and isset($_GET['modo'])) {
    $idGET = $_GET['idMed'];
    $modoGET = $_GET['modo'];
  }

  if (isset($_POST['btnActualizarInventario'])) {
    $idMedicamento = $_POST['idMedicamento'];
    $nomMedicamento = $_POST['nomMedicamento'];
    $stockApartado = $_POST['stockApartado'];
    $stockDisponible = $_POST['stockDisponible'];
    $cantidadActualPorEnvase = $_POST['cantidadActualPorEnvase'];
    $StockTotal = $stockApartado + $stockDisponible;
        
    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE medicamento 
        SET Nombre = ?, 
            StockApartado = ?, 
            StockDisponible = ?, 
            StockTotal = ?, 
            CantidadActualPorEnvase = ?
        WHERE IDMedicamento  = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $nomMedicamento,
      $stockApartado,
      $stockDisponible,
      $StockTotal,
      $cantidadActualPorEnvase,
      $idMedicamento
    ]);

    $ultimoID = $bdd->lastInsertId();
    $resultado = $bdd->query("SELECT * FROM medicamento where IDMedicamento = $ultimoID");

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($resultado) {
      echo "<script>alert('$nomMedicamento actualizado correctamente');</script>";
    } else {
      $error = print_r($stmt->errorInfo());
      echo "<script>alert('Error al actualizar $nomMedicamento ERROR: $error');</script>";
    }

    header("Location: pagina_inventario.php");



  }


  
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
  



?>