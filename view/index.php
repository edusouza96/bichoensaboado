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
        $path = $_SERVER['SERVER_NAME']; 
        if($path=='localhost'){
            $path .=':7777';
        }
        Redirect('http://'.$path.'/bichoensaboado/Calendar/', false);

    }
    $date = $_GET['date'];
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $version = rand(100, 500);
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../dao/DiaryDAO.php");
    include_once("../dao/ServicDAO.php");
    include_once($path."/bichoensaboado/view/inc/util.php");
    $servicDao = new ServicDAO();
    $servicList = $servicDao->SearchAll();
    $servicVetList = $servicDao->SearchVet();
    $diaryDao = new DiaryDAO();
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAll(); 
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
    $addressArray = array();
    foreach ($addressList as $address) {
        $addressArray[$address->idAddress] = $address->valuation;
    }

    foreach ($clientList as $cli){
        $nameAnimalsList[] = strtoupper($cli->nameAnimal);
    }

    $nameAnimalsList = array_unique($nameAnimalsList);
    
    foreach ($nameAnimalsList as $name){
        $f_list[] = array('label' => utf8_encode($name));
    }
   
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Agenda Pet</title>
        
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Horários - Dia <?=dateUs2Br($date)?></h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <input type="hidden" id="dateCurrent" value="<?=$date?>">
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
                    <th>Telefone</th>
                    <th>Serviço Pet</th>
                    <th>Valor Pet</th>
                    <th>Serviço Vet</th>
                    <th>Valor Vet</th>
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

                            echo "<td id='service".$i."'>";
                            echo "</td>";

                            echo "<td id='price".$i."'>";
                            echo "</td>";

                            echo "<td id='serviceVet".$i."'>";
                            echo "</td>";

                            echo "<td id='priceVet".$i."'>";
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
                                $serviceVet = $diary->servicVet->nameServic;
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
                                    echo "<input type='text' id='nameAnimal_".$companion->idDiary."' name='nameAnimal' class='diary-animals-input form-control nameAnimal' value='".$companion->client->nameAnimal."' readonly>";
                                }
                                echo "<div id='addCompanion".$diary->idDiary."'></div>";
                                echo "</td>";

                                echo "<td>";
                                echo '<div class="diary-breed">'.$diary->client->breed->nameBreed.'</div>';
                                foreach ($companionList as $companion) {
                                    echo '<div class="diary-breed">'.$companion->client->breed->nameBreed.'</div>';
                                }
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
                                echo ($diary->client->phone2 == 0) ? "" : " - ".$diary->client->phone2 ;
                                echo "</td>";
                                
                                echo "<td>";
                                echo "<div id='servicWithFieldEdit".$diary->idDiary."' style='display:none'>";
                                echo "<select id='serviceSelect".$diary->idDiary."' name='service' class='form-control'>";
                                echo "<option value='0'>-- Selecione --</option>";
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
                                    echo "<option value='0'>-- Selecione --</option>";
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
                                // VET
                                echo "<td>";
                                echo "<div id='servicVetWithFieldEdit".$diary->idDiary."' style='display:none'>";
                                echo "<select id='serviceVetSelect".$diary->idDiary."' name='serviceVet' class='form-control'>";
                                echo "<option value='0'>-- Selecione --</option>";
                                foreach($servicVetList as $servicVet){
                                    if($servicVet->idServic == $diary->servicVet->idServic){
                                        echo "<option value=".$servicVet->idServic." selected>".$servicVet->nameServic."</option>";
                                    }else{
                                        echo "<option value=".$servicVet->idServic.">".$servicVet->nameServic."</option>";
                                    }
                                }
                                echo "</select>";
                                // 
                                foreach ($companionList as $companion) {
                                    echo "<select id='serviceVetSelect".$companion->idDiary."' name='serviceVet' class='form-control'>";
                                    echo "<option value='0'>-- Selecione --</option>";
                                    foreach($servicVetList as $servicVet){
                                        if($servicVet->idServic == $companion->servicVet->idServic){
                                            echo "<option value=".$servicVet->idServic." selected>".$servicVet->nameServic."</option>";
                                        }else{
                                            echo "<option value=".$servicVet->idServic.">".$servicVet->nameServic."</option>";
                                        }
                                    }
                                    echo "</select>";
                                }
                                // 
                                echo "</div>";

                                echo "<div id='servicVetWithoutFieldEdit".$diary->idDiary."'>";
                                echo $serviceVet;
                                foreach ($companionList as $companion) {
                                    echo '</br></br>'.$companion->servicVet->nameServic;
                                }
                                echo "</div>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->priceVet;
                                foreach ($companionList as $companion) {
                                    echo '</br></br>'.$companion->priceVet;
                                }
                                echo "</td>";
                                // END VET
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
                                    echo $diary->isPay() ? "Finalizado" : "<input type='button' onClick='finish(".$diary->idDiary.",2);' value='Pagar'/><br><input type='button' onClick='canc(".$diary->idDiary.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                }else if($diary->status == -1){
                                    echo "Cancelado";
                                }else if($diary->status == 1){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",2);' value='Finalizar'/>";
                                    echo "<input type='button' onClick='dataToModal(".$diary->idDiary.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
                                    echo "<br><input type='button' onClick='canc(".$diary->idDiary.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                }else if($diary->status == 0){
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.",1);' value='Check-in'/>";
                                    echo "<input type='button' onClick='payAnticipate(".$diary->idDiary.");' value='Pagar'/>";
                                    echo "<br><input type='button' onClick='canc(".$diary->idDiary.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                    echo "<input type='button' onClick='dataToModal(".$diary->idDiary.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
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
                    <div class="modal-content">
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

                                    <div class="form-group">  <!--div service Pet-->
                                        <label for="servic-add">Serviço Pet</label>
                                        <select id="servicAdd" name="servic" class="form-control" onChange="showFormSelectDaysPackageAnimalSameOwner();" disabled></select>
                                    </div><!-- end div service Pet-->

                                    <div  id="modalRowsSelectDaysAnimalSameOwner">
                                        <!-- elementos adicionados via function JS  -->
                                    </div>

                                    <div class="form-group">  <!--div service Vet-->
                                        <label for="servic-vet-add">Serviço Vet</label>
                                        <select id="servicVetAdd" name="servicVet" class="form-control" disabled></select>
                                    </div><!-- end div service Vet-->
                                </div> 
                            </div><!-- end div line -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="saveAnimalSameOwner();" >Confirmar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div><!--Fim Modal adição de animal do mesmo dono-->

                <!-- Modal seleção de dias do pacote -->
                <div class="modal fade" id="modalSelectDaysPackage" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content" style="width: 70%;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Selecionar Dias do Pacote</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row"> <!--div line head -->
                                    <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1">
                                        <div class="form-group"> 
                                            <strong id="modalHeadPackageOrder">#</strong>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                                        <div class="form-group"> 
                                            <strong id="modalHeadPackageDate">Data</strong>
                                        </div>
                                    </div>

                                    <div class="col-xs-5 col-sm-5 col-lg-5 col-md-5">
                                        <div class="form-group"> 
                                            <strong id="modalHeadPackageHour">Hora</strong>
                                        </div>
                                    </div>
                                </div> <!-- end div line head -->

                                <div  id="modalRowsSelectDays">
                                    <!-- elementos adicionados via function JS  -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="dateHourPackage" id="dateHourPackage" value />
                                <button type="button" class="btn btn-success" data-dismiss="modal" onClick="defineDateHourPackage();">Confirmar</button>
                            </div>
                        </div>

                    </div>
                </div> <!--Fim Modal seleção de dias do pacote -->
                
            </tbody>
        </table>
    </body>
</html>

<?php
    include_once($path."/bichoensaboado/view/inc/jsHeader.php");
?>

<script>
    function completeNameAnimal(){
        $(".nameAnimal").autocomplete({
            source: <?php 
                        echo json_encode($f_list);
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