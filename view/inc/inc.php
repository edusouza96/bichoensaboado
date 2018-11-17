<?php
    header('Content-Type: text/html; charset=utf-8');

    if($_SERVER['SERVER_NAME'] == 'localhost'){
        $urlBase = "http://".$_SERVER['SERVER_NAME'].":7777";
    }else{
        $urlBase = "https://".$_SERVER['SERVER_NAME'];
    }
    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $pathFile = $_SERVER['SCRIPT_NAME'];

    session_start();
    if(empty($_SESSION["userOnline"])){
        header("location:$urlBase/bichoensaboado/view/login/index.php?code=401-l");  
    }

    include_once($path."/bichoensaboado/class/LoginClass.php");
    $dataLogin = unserialize($_SESSION['userOnline']);
    $admin = true;
    $developer = false;
    if($dataLogin->role == 3){
        $admin = false;
    }else if($dataLogin->role == 1){
        $developer = true;
    }

    if($dataLogin->store == 1){
        $labelChangeStore = "Trocar Para Loja 2";
    }else{
        $labelChangeStore = "Trocar Para Loja 1";
    }

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
        <input type="hidden" value="<?=$urlBase?>" id="urlBase">
        <nav id="menu">
            <ul>
                <li><a href="/bichoensaboado/view/dashboard.php">Dashboard</a></li>
                <li><a href="/bichoensaboado/">Agenda Pet</a></li>
                <li><a href="/bichoensaboado/view/client/">Clientes</a></li>
                <li><a href="/bichoensaboado/view/address/">Bairro</a></li>
                <li><a href="/bichoensaboado/view/breed/">Raças</a></li>
                <li><a href="/bichoensaboado/view/servic/">Serviços</a></li>
                <li><a href="/bichoensaboado/view/product/">Produtos</a></li>
                <li><a href="/bichoensaboado/view/rebate/">Descontos</a></li>
                <?php
                if($dataLogin->role != 3){
                ?>
                    <li><a href="/bichoensaboado/view/financial/SaveOutlay.php">Registrar Gastos</a></li>
                    <li><a href="/bichoensaboado/view/center-cost/">Centro de Custo</a></li>
                    <li><a href="/bichoensaboado/view/financial/TransferTreasury.php">Transferir dinheiro</a></li>
                    <li><a href="/bichoensaboado/view/sales/salesOfDay.php">Vendas do dia</a></li>
                    <li><a href="/bichoensaboado/view/report/">Relatórios</a></li>
                <?php
                }
                ?>

                <li><a href="/bichoensaboado/view/sales/">PDV</a></li>

                <?php
                if(!$disabledLink && $textLink != "Abrir Caixa"){
                ?>
                    <li><a class="cursor-link" id="link-treasurer" onclick="openCloseTreasurer(<?=$option?>);"><?=$textLink?></a></li>
                <?php
                }
                ?>

                <?php
                if($dataLogin->role != 3){
                ?>
                    <li><a href="#" onclick="changeStore(<?=$dataLogin->store?>)"><?=$labelChangeStore?></a></li>
                <?php
                }
                ?>

                <li><a href="/bichoensaboado/view/login/">Sair</a></li>
            </ul>
        </nav>
        <?php
            include_once($path."/bichoensaboado/view/financial/dayMovement.php");
        ?>
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
    var pageNow = window.location.pathname;
    var pathPageNow = pageNow.split('/');
    if(pathPageNow.length == 4 && pathPageNow[3] == 'index.php'){
        var url = "ajax/treasurer.php?option="+option; 
    }else{
        var url = "../ajax/treasurer.php?option="+option; 
    }
    ajaxOpenCloseTreasurer(url);
}

function changeStore(currentStore){
    var url = $('#urlBase').val()+"/bichoensaboado/view/ajax/changeStore.php";
    $.get(url, {
        currentStore: currentStore
    }).done(function(data) {
        location.reload();
    });
}
</script>
