<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/TreasurerDAO.php");
    $disabledLink = false;
    $treasurerDao = new TreasurerDAO();
    $treasurerDao->addWhere(" SUBSTRING(dateRegistryTreasurer,1,10) = curdate()");
    $treasurerList = $treasurerDao->searchAll();
    if(empty($treasurerList)){
        $textLink = "Abrir Caixa";
        $option = 1;
    }else{
        $textLink = "Fechar Caixa";
        $option = 2;
        if($treasurerList[0]->closingMoneyDayTreasurer != null){
            $disabledLink = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="/bichoensaboado/css/menu.css">
    </head>
    <body>
        <nav id="menu">
            <ul>
                <li><a href="/bichoensaboado/">Agenda</a></li>
                <li><a href="/bichoensaboado/view/client/">Clientes</a></li>
                <li><a href="/bichoensaboado/view/address/">Bairro</a></li>
                <li><a href="/bichoensaboado/view/breed/">Raças</a></li>
                <li><a href="/bichoensaboado/view/servic/">Serviços</a></li>
                <li><a href="/bichoensaboado/view/product/">Produtos</a></li>
                <li><a href="/bichoensaboado/view/financial/">Financeiro</a></li>
                <li><a href="/bichoensaboado/view/sales/">PDV</a></li>
                <?php
                if(!$disabledLink){
                ?>
                <li><a class="cursor-link" id="link-treasurer" onclick="openCloseTreasurer(<?=$option?>);"><?=$textLink?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </body>
</html>
<div id="alert" class="alert info">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <p id="msg-alert"></p>
</div>

<style>
.cursor-link{
    cursor:pointer;
}
.info{
    background-color: #2196F3 !important;
}
.alert {
    padding: 10px;
    background-color: #f44336;
    color: white;
    display: none;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>

<script>
/**
 * @param {*} option
 * 1 = open 
 * 2 = close
 */
 function openCloseTreasurer(option){
    var url = "ajax/treasurer.php?option="+option; 
    ajaxOpenCloseTreasurer(url);
}
</script>