<?php
class selectBrinde{
  function selectAllObjetoBrinde(){
      include('conexao.php');
      $query = "SELECT oe.nome_objeto_brinde FROM objeto_brinde oe";
      $result = mysqli_query($con, $query);
      while ($data = mysqli_fetch_array($result)){
          $nome_objeto = $data['nome_objeto_brinde'];
      
          echo "<option value='$nome_objeto'>";
     
      }
  }
}

?>