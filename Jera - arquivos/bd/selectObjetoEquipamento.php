<?php


class selectEquipamento{
    function selectAllObjetoEquip(){
        include('conexao.php');
        $query = "SELECT * FROM  objeto_equipamento;";
        $result = mysqli_query($con, $query);
        while ($data = mysqli_fetch_array($result)){
            $nome_objeto = $data['nome_objeto_equipamento'];
        ?>
            <option value="<?php echo $nome_objeto; ?>">
        <?php
        }
    }

    function selectEstadoEquip(){
        include('conexao.php');
        $query_datalist = "SELECT * FROM estado_conservacao";
                            $result_datalist = mysqli_query($con, $query_datalist);
                            while ($data = mysqli_fetch_array($result_datalist)){
                                $nome_estado = $data['estado_conservacao'];
                                $id_estado = $data['id_estado_conservacao']
                                ?>
                                <li class="estado" value="<?php echo $id_estado;?>"><a class="dropdown-item" href="#"><?php echo $nome_estado; ?></a></li>
                                
                                <?php
                            }    
    }
}
?>