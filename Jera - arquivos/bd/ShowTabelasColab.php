<?php

class preenchertabelas
{
    
    function tabelaSolicitarEquipamentoColab()
    {
        include("conexao.php");
        $query = "SELECT id_equipamento ,nome_objeto_equipamento, descricao FROM equipamento e
        JOIN status_equipamento se ON se.id_status_equipamento = e.fk_status
        JOIN objeto_equipamento oe ON oe. id_objeto_equipamento = e.id_equipamento";
        
        $result = mysqli_query($con, $query);
        $row = mysqli_num_rows($result);

        if ($row == '') {
            echo "<h3>Não existem dados cadastrados</h3>";
        } 

        else 
        {
            while ($data = mysqli_fetch_array($result)){
                $id = $data['id_equipamento'];
                $objeto = $data['nome_objeto_equipamento'];
                $descricao = $data['descricao'];
                $stringid = strval($id);
                
            ?>
            <tr class="parentRow">
                <td><?php echo $objeto; ?></td>
                <td><?php echo $descricao; ?></td>
                <td><button class="btn_solicitarEquipament" onclick="abrirAviso('<?php echo '.modalsolicitacao'. $stringid; ?>')">Solicitar</button></td>
            </tr>
            <tr class="subRow" style="display: none;">
                <td></td>
            </tr>
          <?php
            }
        }
    }
}
?>