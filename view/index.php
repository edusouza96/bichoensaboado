<?php
    if(empty($_GET['date'])){
        function Redirect($url, $permanent = false)
        {
            if (headers_sent() === false)
            {
                header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
            }

            exit();
        }

        Redirect('http://localhost:8080/bichoensaboado/Calendar/', false);

    }
    $date = $_GET['date'];
    $path = $_SERVER['DOCUMENT_ROOT']; 
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../dao/DiaryDAO.php");
    $diaryDao = new DiaryDAO();
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAll(); 
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Agenda Pet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script language="javascript" src="../js/ajax.js?v=<?=rand(100, 500)?>"></script>
        <script language="javascript" src="../js/functionsDiary.js?v=<?=rand(100, 500)?>"></script>
        <link rel="stylesheet" href="../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Hor�rios</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Nome Animal</th>
                    <th>Ra�a</th>
                    <th>Propriet�rio</th>
                    <th>Busca</th>
                    <th>Endere�o</th>
                    <th>Bairro</th>
                    <th>Telefone 1</th>
                    <th>Telefone 2</th>
                    <th>Servi�o</th>
                    <th>Valor</th>
                    <th>Taxa de Entrega</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $hour = '08:00';
                    for($i =1; $i < 20; $i++){
                        $diaryList = $diaryDao->SearchDateHour($date.' '.$hour);
                        if(empty($diaryList)){
                            echo "<tr onClick='positionRow(this);'>";

                            echo "<td id='hour".$i."' onClick='addRow(&quot;".$hour."&quot; , &quot;".$date."&quot;);'>";
                            echo $hour;
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='text' id='nameAnimal".$i."' name='nameAnimal' onKeyPress='completeNameAnimal();' onBlur='selectOwner(this.value,".$i.");' class='form-control nameAnimal'>";
                            echo "</td>";

                            echo "<td id='breed".$i."'>";
                            echo "</td>";

                            echo "<td id='ownerTD".$i."'>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='checkbox' id='search".$i."' onClick='deliveryChecked(this, ".$i.");' name='search' value='1' class='form-control'>";
                            echo "</td>";

                            echo "<td id='address".$i."'>";
                            echo "</td>";

                            echo "<td id='district".$i."'>";
                            echo "</td>";

                            echo "<td id='phone1".$i."'>";
                            echo "</td>";

                            echo "<td id='phone2".$i."'>";
                            echo "</td>";
                            
                            echo "<td id='service".$i."'>";
                            echo "</td>";

                            echo "<td id='price".$i."'>";
                            // echo "<input type='text' id='price".$i."' name='price' class='form-control'>";
                            echo "</td>";

                            echo "<td id='deliveryPrice".$i."'>";
                            // echo "<input type='text' id='deliveryPrice".$i."' name='deliveryPrice' class='form-control'>";
                            echo "</td>";

                            echo "<td id='totalPrice".$i."'>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='button' id='save".$i."' onClick='save(".$i.",&quot;".$date."&quot;)' value='Agendar'/>";
                            echo "</td>";

                            echo "</tr>";
                            
                        }else{
                            foreach($diaryList as $diary){
                                $week = '';
                                if($diary->package->idPackage > 0){
                                    for($iPack = 1; $iPack<5; $iPack++){
                                        $datePack = 'date'.$iPack;
                                        $weekPack = 'week'.$iPack;
                                        if($diary->dateHour == $diary->package->${'datePack'}){
                                            $week = $diary->package->${'weekPack'};
                                            break;
                                        }
                                    }
                                }
                                if(!empty($week)){
                                    $service = $diary->servic->nameServic.'<br>Banho '.$week;
                                }else{
                                    $service = $diary->servic->nameServic;
                                }
                                $bgColor = '';
                                if($diary->status == 2){
                                    $bgColor = "style='background: rgba(255, 0, 0, 0.6);'";
                                }else if($diary->status == -1){                                                                        
                                    $bgColor = "style='background: rgba(255, 0, 0, 0.6);'";
                                }else if($diary->status == 1){
                                    $bgColor = "style='background: rgba(24,202,39,0.6);'";
                                }else if($diary->status == 0){
                                    $bgColor = "style='background: rgba(222,217,8,0.6);'";
                                }
                                echo "<tr ".$bgColor." id='tr".$diary->idDiary."' onClick='positionRow(this);'>";

                                $dHour = new DateTime($diary->dateHour);
                                $dHourShow = $dHour->format('H:i');
                                echo "<td onClick='addRow(&quot;".$dHourShow."&quot; , &quot;".$date."&quot;);'>";
                                echo $dHourShow;
                                echo "</td>";

                                echo "<td>";
                                echo "<input type='text' id='nameAnimal' name='nameAnimal' class='form-control nameAnimal' value='".$diary->client->nameAnimal."' readonly>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->breed->nameBreed;
                                echo "</td>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->owner;
                                echo "</td>";

                                echo "<td>";
                                if($diary->search == 1){
                                    echo"<input type='checkbox' id='search' name='search' value='1' class='form-control' disabled checked>";
                                }else{
                                    echo"<input type='checkbox' id='search' name='search' value='1' class='form-control' disabled>";
                                }
                                echo "</td>";

                                echo "<td>";
                                if($diary->search == 1)
                                    echo $diary->client->addressNumber;
                                echo "</td>";

                                echo "<td>";
                                if($diary->search == 1)
                                    echo $diary->client->address->district;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone1;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone2;
                                echo "</td>";
                                
                                echo "<td>";
                                echo $service;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->price;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->deliveryPrice;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->totalPrice;
                                echo "</td>";

                                echo "<td id='status".$diary->idDiary."' >";
                                if($diary->status == 2){
                                    echo "Finalizado";
                                }else if($diary->status == -1){
                                    echo "Cancelado";
                                }else if($diary->status == 1){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",2);' value='Finalizar'/>";                                
                                }else if($diary->status == 0){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",1);' value='Check-in'/>";
                                    echo "<input type='button' onClick='teste(".$diary->idDiary.",&quot;".$date."&quot;,&quot;".$dHourShow."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
                                    echo "<br><input type='button' onClick='finish(".$diary->idDiary.", -1);' value='Cancelar'/>";

                                }
                                echo "</td>";

                                echo "</tr>";
                                
                            }
                        }
                        $hour =  date('H:i', strtotime('+30 minute', strtotime($hour)));
                    }                        
                ?>
                 <!-- Modal -->
                <div class="modal fade" id="modalEdit" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Re-Agendar</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row"> <!--div line dateHour-->
                                <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"> <!--div date-->
                                    <div class="form-group"> 
                                        <label for="dateEdit">Data</label>
                                        <input type="date" id="dateEdit" name="dateEdit" class="form-control" value>
                                    </div>
                                </div> <!-- end div date-->
                                <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div hour-->
                                    <div class="form-group"> 
                                        <label for="hourEdit">Hora</label>
                                        <input type="time" id="hourEdit" name="hourEdit" class="form-control" value>
                                        <input type="hidden" id="idEdit" name="idEdit" class="form-control" value>
                                    </div>
                                </div> <!-- end div hour-->
                            </div><!-- end div line dateHour-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="update();">Salvar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div>
                
            </tbody>
        </table>
       
    </body>
</html>
<script>
    function completeNameAnimal(){
        $(".nameAnimal").autocomplete({
            source: <?php 
                        echo json_encode($clientDao->SearchName());
                    ?>
        });
    }
</script>