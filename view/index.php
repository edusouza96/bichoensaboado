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

        Redirect('http://localhost:7777/bichoensaboado/Calendar/', false);

    }
    $date = $_GET['date'];
    $path = $_SERVER['DOCUMENT_ROOT']; 
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../dao/DiaryDAO.php");
    include_once("../dao/ServicDAO.php");
    $servicDao = new ServicDAO();
    $servicList = $servicDao->SearchAll();
    $diaryDao = new DiaryDAO();
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAll(); 
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
    $addressArray = array();
    foreach ($addressList as $address) {
        $addressArray[$address->idAddress] = $address->valuation;
    }
   
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
            <h2>Horários</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Nome Animal</th>
                    <th>Raça</th>
                    <th>Proprietário</th>
                    <th>Busca</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Telefone 1</th>
                    <th>Telefone 2</th>
                    <th>Serviço</th>
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
                                $companionList = $diaryDao->SearchCompanion($diary->idDiary);
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
                                echo "<td id='hour_".$diary->idDiary."' onClick='addRow(&quot;".$dHourShow."&quot; , &quot;".$date."&quot;);'>";
                                echo $dHourShow;
                                echo "</td>";

                                echo "<td>";
                                echo "<input type='text' id='nameAnimal_".$diary->idDiary."' name='nameAnimal' class='form-control nameAnimal' value='".$diary->client->nameAnimal."' readonly>";
                                foreach ($companionList as $companion) {
                                    echo "<input type='text' id='nameAnimal_".$companion->idDiary."' name='nameAnimal' class='form-control nameAnimal' value='".$companion->client->nameAnimal."' readonly>";
                                }
                                echo "<div id='addCompanion".$diary->idDiary."'></div>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->breed->nameBreed;
                                foreach ($companionList as $companion) {
                                    echo '</br></br>'.$companion->client->breed->nameBreed;
                                }
                                echo "</td>";
                                echo "</td>";

                                // echo "<td class='cursor' data-toggle='modal' data-target='#modalAdd' >";
                                echo "<td class='cursor' data-toggle='modal' data-target='#modalAdd' onClick='addAnimalSameOwner(".$diary->client->idOwner.",".$diary->idDiary.");' >";
                                echo $diary->client->owner;
                                echo "</td>";

                                echo "<td>";
                                if($diary->search == 1){
                                    echo"<input type='checkbox' id='search_".$diary->idDiary."' name='search' value='1' class='form-control' disabled checked>";
                                }else{
                                    echo"<input type='checkbox' id='search_".$diary->idDiary."' name='search' value='1' class='form-control' disabled>";
                                }
                                echo "</td>";

                                echo "<td id='tdAddress_".$diary->idDiary."'>";
                                if($diary->search == 1)
                                    echo $diary->client->addressNumber;
                                 else
                                    echo "<input type='hidden' id='address_".$diary->idDiary."' value='".$diary->client->addressNumber."' >";
                                echo "</td>";

                                echo "<td id='tdDistrict_".$diary->idDiary."'>";
                                if($diary->search == 1)
                                    echo $diary->client->address->district;
                                else
                                    echo "<input type='hidden' id='district_".$diary->idDiary."' value='".$diary->client->address->district."' >";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone1;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone2;
                                echo "</td>";
                                
                                echo "<td>";
                                echo "<div id='servicWithFieldEdit".$diary->idDiary."' style='display:none'>";
                                echo "<select id='serviceSelect".$diary->idDiary."' name='service' class='form-control'>";
                                foreach($servicList as $servic){
                                    if($servic->breed->idBreed == $diary->client->breed->idBreed){
                                        if($servic->idServic == $diary->servic->idServic){
                                            echo "<option value=".$servic->idServic." selected>".$servic->nameServic."</option>";
                                        }else{
                                            echo "<option value=".$servic->idServic.">".$servic->nameServic."</option>";
                                        }
                                    }
                                }
                                echo "</select>";
                                // 
                                foreach ($companionList as $companion) {
                                    echo "<select id='serviceSelect".$companion->idDiary."' name='service' class='form-control'>";
                                    foreach($servicList as $servic){
                                        if($servic->breed->idBreed == $companion->client->breed->idBreed){
                                            if($servic->idServic == $companion->servic->idServic){
                                                echo "<option value=".$servic->idServic." selected>".$servic->nameServic."</option>";
                                            }else{
                                                echo "<option value=".$servic->idServic.">".$servic->nameServic."</option>";
                                            }
                                        }
                                    }
                                    echo "</select>";
                                }
                                // 
                                echo "</div>";

                                echo "<div id='servicWithoutFieldEdit".$diary->idDiary."'>";
                                echo $service;
                                foreach ($companionList as $companion) {
                                    echo '</br></br>'.$companion->servic->nameServic;
                                }
                                echo "</div>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->price;
                                foreach ($companionList as $companion) {
                                    echo '</br></br>'.$companion->price;
                                }
                                echo "</td>";

                                echo "<td id='tdDeliveryPrice_".$diary->idDiary."'>";
                                if($diary->deliveryPrice > 0)
                                    echo $diary->deliveryPrice;
                                else
                                    echo "<input type='hidden' id='deliveryPrice_".$diary->idDiary."' value='".$addressArray[$diary->client->address->idAddress]."' >";
                                echo "</td>";

                                echo "<td>";
                                $totalPriceC = 0;
                                foreach ($companionList as $companion) {
                                    $totalPriceC += $companion->totalPrice;
                                }
                                echo $diary->totalPrice + $totalPriceC;
                                echo "</td>";

                                echo "<td id='status".$diary->idDiary."' >";
                                if($diary->status == 2){
                                    echo "Finalizado";
                                }else if($diary->status == -1){
                                    echo "Cancelado";
                                }else if($diary->status == 1){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",2);' value='Finalizar'/>";
                                    echo "<input type='button' onClick='dataToModal(".$diary->idDiary.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
                                    echo "<br><input type='button' onClick='canc(".$diary->idDiary.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                }else if($diary->status == 0){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",1);' value='Check-in'/>";
                                    echo "<input type='button' onClick='dataToModal(".$diary->idDiary.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
                                    echo "<br><input type='button' onClick='canc(".$diary->idDiary.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                }
                                echo "</td>";

                                echo "</tr>";
                                
                            }
                        }
                        $hour =  date('H:i', strtotime('+30 minute', strtotime($hour)));
                    }                        
                ?>
                
                 <!-- Modal Cancelamento -->
                <div class="modal fade" id="modalCanc" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content" style="width: 50%;">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cancelar Banho</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row"> <!--div line password-->
                                <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10"> <!--div password-->
                                    <div class="form-group"> 
                                        <label for="password">Senha</label>
                                        <input type="password" id="password" name="password" class="form-control" value>
                                        <input type="hidden" id="idCanc" name="idCanc" class="form-control" value>
                                    </div>
                                </div> <!-- end div password-->
                            </div><!-- end div line password-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="finish(0,-1);">Confirmar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div><!--Fim Modal Cancelamento-->

                <!-- Modal Edição -->
                <div class="modal fade" id="modalEdit" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content" style="width: 50%;">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Banho</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row"> <!--div line password-->
                                <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10"> <!--div password-->
                                    <div class="form-group"> 
                                        <label for="password1">Senha</label>
                                        <input type="password" id="password1" name="password1" class="form-control" value>
                                        <input type="hidden" id="idEdit" name="idEdit" class="form-control" value>
                                        <input type="hidden" id="hourEdit" name="hourEdit" class="form-control" value>
                                        <input type="hidden" id="dateEdit" name="dateEdit" class="form-control" value>
                                    </div>
                                </div> <!-- end div password-->
                            </div><!-- end div line password-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="activeFiedsForUpdate();" >Confirmar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div><!--Fim Modal Edição-->

                <!-- Modal adição de animal do mesmo dono -->
                <div class="modal fade" id="modalAdd" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content" style="width: 60%;">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adicionar</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row"> <!--div line -->
                                <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10">
                                    <div class="form-group">  <!--div name animal -->
                                        <input type="hidden" id="idDiary-add">
                                        <label for="nameAnimal-add">Nome Animal</label>
                                        <div id='inputName'></div>
                                        
                                    </div><!-- end div name animal-->

                                    <div class="form-group">  <!--div service-->
                                        <label for="servic-add">Serviço</label>
                                        <select id="servicAdd" name="servic" class="form-control" disabled></select>
                                    </div><!-- end div service-->
                                </div> 
                            </div><!-- end div line -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="saveAnimalSameOwner();" >Confirmar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div><!--Fim Modal adição de animal do mesmo dono-->
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
<!--
***Status Banhos***
    Cancelado = -1
    Agendadao = 0
    Presente = 1
    Finalizado = 2
-->