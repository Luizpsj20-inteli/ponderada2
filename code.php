<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page</h1>
<?php
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the NOVA_TABELA table exists. */
  VerifyNovaTabela($connection, DB_DATABASE);

  /* If input fields for NOVA_TABELA are populated, add a row to the NOVA_TABELA table. */
  $product_name = htmlentities($_POST['PRODUCT_NAME']);
  $price = floatval($_POST['PRICE']);
  $in_stock = filter_var($_POST['IN_STOCK'], FILTER_VALIDATE_BOOLEAN);
  $description = htmlentities($_POST['DESCRIPTION']);

  if (!empty($product_name) || !empty($price) || isset($in_stock) || !empty($description)) {
    AddDataToNovaTabela($connection, $product_name, $price, $in_stock, $description);
  }

  /* Check if the "Excluir Todos os Dados da NOVA_TABELA" button was pressed. */
  if (isset($_POST['delete_data'])) {
    // Execute a SQL statement to delete all data from the NOVA_TABELA table.
    $deleteQuery = "DELETE FROM NOVA_TABELA";
    if (mysqli_query($connection, $deleteQuery)) {
        echo "Todos os dados da tabela NOVA_TABELA foram excluídos com sucesso.";
    } else {
        echo "Erro ao excluir dados da tabela NOVA_TABELA: " . mysqli_error($connection);
    }
  }
?>
<!-- Input form for NOVA_TABELA -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>PRODUCT_NAME</td>
      <td>PRICE</td>
      <td>IN_STOCK</td>
      <td>DESCRIPTION</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="PRODUCT_NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="PRICE" />
      </td>
      <td>
        <input type="checkbox" name="IN_STOCK" />
      </td>
      <td>
        <textarea name="DESCRIPTION" rows="3" cols="30"></textarea>
      </td>
      <td>
        <input type="submit" value="Add Data to NOVA_TABELA" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data for NOVA_TABELA. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>PRODUCT_NAME</td>
    <td>PRICE</td>
    <td>IN_STOCK</td>
    <td>DESCRIPTION</td>
  </tr>

<?php
$result = mysqli_query($connection, "SELECT * FROM NOVA_TABELA");

while ($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>", $query_data[0], "</td>",
       "<td>", $query_data[1], "</td>",
       "<td>", $query_data[2], "</td>",
       "<td>", $query_data[3] ? 'Yes' : 'No', "</td>",
       "<td>", $query_data[4], "</td>";
  echo "</tr>";
}
?>

</table>

<!-- Excluir Todos os Dados da NOVA_TABELA -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <input type="submit" name="delete_data" value="Excluir Todos os Dados da NOVA_TABELA" />
</form>

<!-- Clean up. -->
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

</body>
</html>

<?php
/* Add data to the NOVA_TABELA table. */
function AddDataToNovaTabela($connection, $product_name, $price, $in_stock, $description) {
  $pn = mysqli_real_escape_string($connection, $product_name);
  $p = floatval($price);
  $is = $in_stock ? 1 : 0;
  $d = mysqli_real_escape_string($connection, $description);

  $query = "INSERT INTO NOVA_TABELA (PRODUCT_NAME, PRICE, IN_STOCK, DESCRIPTION) VALUES ('$pn', '$p', '$is', '$d');";

  if (!mysqli_query($connection, $query)) echo("<p>Error adding data to NOVA_TABELA table.</p>");
}

/* Check whether the table exists and, if not, create it for NOVA_TABELA. */
function VerifyNovaTabela($connection, $dbName) {
  if (!TableExists("NOVA_TABELA", $connection, $dbName)) {
     $query = "CREATE TABLE NOVA_TABELA (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         PRODUCT_NAME VARCHAR(45),
         PRICE FLOAT,
         IN_STOCK BOOLEAN,
         DESCRIPTION TEXT
       )";

     if (!mysqli_query($connection, $query)) echo("<p>Error creating NOVA_TABELA table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if (mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
