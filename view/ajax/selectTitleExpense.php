<?php
    $idCategory = $_GET['idCategory'];
    if($idCategory > 0){
        $path = $_SERVER['DOCUMENT_ROOT']; 

        include_once($path."/bichoensaboado/dao/CenterCostDAO.php");
        include_once($path."/bichoensaboado/class/CenterCostClass.php");
        include($path."/bichoensaboado/inc/functions.php");

        $centerCostDAO = new CenterCostDAO();
        $centerCostDAO->addWhere(" category_expense_financial_idCategoryExpenseFinancial = ".$idCategory);
        $centerCostList = $centerCostDAO->searchAll();

        echo listObject2Json($centerCostList);
    }
?>