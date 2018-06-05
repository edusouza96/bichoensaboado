<?php
    $nameReport = "relatorio".date("dmY_Hmi").".xls";
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel');
    header ("Content-Disposition: attachment; filename=\"{$nameReport}\"");
    error_reporting(0);    

    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    
    if(!empty($_GET['dateStart'])){
        $dateStart = $_GET['dateStart'];
        $reportDao->addWhere(" dateHour >= '".$dateStart." 00:00:00'");
    }
    if(!empty($_GET['dateEnd'])){
        $dateEnd = $_GET['dateEnd'];
        $reportDao->addWhere(" dateHour <= '".$dateEnd." 23:59:59'");
    }
    $reportList = $reportDao->reportClientAttendedByBreed();    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="2" class="text-right">
                        <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        <i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <th>Raça</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalQuantity = 0;
                    foreach($reportList as $item){
                ?>
                       <tr>
                           <td><?=$item->column2Report?></td>
                           <td><?=$item->column1Report?></td>
                       </tr>
                <?php   
                        $totalQuantity += $item->column1Report;
                    }
                ?>
                <tr class="row-total">
                    <td>TOTAL</td>
                    <td><?=$totalQuantity?></td>
                </tr>
                
            </tbody>
        </table>
       
    </body>
</html>