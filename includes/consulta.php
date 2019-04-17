<?php
include("conexion.php");
global $conexion;
$query = "SELECT DISTINCT categoria from marca";
$result = mysqli_query($conexion, $query);
while($row = mysqli_fetch_array($result))
{
    echo '<option value="' .$row["categoria"]. '">' .$row["categoria"]. '</option>';
}
mysqli_close($conexion);

 ?>
