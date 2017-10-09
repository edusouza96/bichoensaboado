<?php
    $nameReport = "relatorio".date("dmY_Hmi").".xls";
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel');
    header ("Content-Disposition: attachment; filename=\"{$nameReport}\"");
    error_reporting(0);    

    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    
    if(!empty($_POST['dateStart'])){
        $dateStart = $_POST['dateStart'];
        $reportDao->addWhere(" dateHour >= '".$dateStart." 00:00:00'");
    }
    if(!empty($_POST['dateEnd'])){
        $dateEnd = $_POST['dateEnd'];
        $reportDao->addWhere(" dateHour <= '".$dateEnd." 23:59:59'");
    }
    $reportList = $reportDao->reportSearchDoneByDistrict();    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="3" class="text-right">
                        <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        <i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <th>Quantidade</th>
                    <th>Bairro</th>
                    <th>Valor gerado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($reportList as $item){
                ?>
                       <tr>
                           <td><?=$item->column1Report?></td>
                           <td><?=$item->column2Report?></td>
                           <td><?=$item->column3Report?></td>
                       </tr>
                <?php   
                    }
                ?>
                
            </tbody>
        </table>
       
    </body>
</html>