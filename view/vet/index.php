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
        Redirect('http://'.$path.'/bichoensaboado/Calendar/indexVet.php', false);

    }
    $date = $_GET['date'];
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $version = rand(100, 500);
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../../dao/VetDAO.php");
    include_once("../../dao/ServicDAO.php");
    include_once($path."/bichoensaboado/view/inc/util.php");
    $servicDao = new ServicDAO();
    $servicList = $servicDao->SearchVet();
    $vetDao = new VetDAO();
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAll(); 
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
    $addressArray = array();
    foreach ($addressList as $address) {
        $addressArray[$address->idAddress] = $address->valuation;
    }

    foreach ($clientList as $cli){
        $f_list[] = array('label' => utf8_encode($cli->nameAnimal));
    }
   
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Agenda Veterinária</title>
        
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Agenda Veterinária - Dia <?=dateUs2Br($date)?></h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <input type="hidden" id="dateCurrent" value="<?=$date?>">
        <table border="1" id="tableVet" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Nome Pet</th>
                    <th>Raça</th>
                    <th>Proprietário</th>
                    <th>Remoção<br>Veterinária</th>
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
                        $vetList = $vetDao->SearchDateHour($date.' '.$hour);
                        if(empty($vetList)){
                            echo "<tr onClick='vetPositionRow(this);'>";

                            echo "<td id='hour".$i."' onClick='vetAddRow(&quot;".$hour."&quot; , &quot;".$date."&quot;);'>";
                            echo $hour;
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='text' id='nameAnimal".$i."' name='nameAnimal' onKeyPress='completeNameAnimal();' onBlur='vetSelectOwner(this.value,".$i.");' class='form-control nameAnimal'>";
                            echo "</td>";

                            echo "<td id='breed".$i."'>";
                            echo "</td>";

                            echo "<td id='ownerTD".$i."'>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='checkbox' id='search".$i."' onClick='vetDeliveryChecked(this, ".$i.");' name='search' value='1' class='form-control'>";
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
                            echo "<select id='serviceSelect".$i."' name='service' class='form-control' onChange='vetSelectValuation(this.value,".$i." );' >";
                            echo "<option value>-- Selecione --</option>";
                                foreach($servicList as $servic){
                                    echo "<option value=".$servic->idServic.">".$servic->nameServic."</option>";
                                }
                            echo "</select>";
                            echo "</td>";

                            echo "<td id='price".$i."'>";
                            echo "</td>";

                            echo "<td id='delivery".$i."'>";
                            echo "<input type='text' size='2' id='deliveryPrice".$i."' onBlur='vetCalcGross(this.value, ".$i.");' name='deliveryPrice' class='form-control'>";
                            echo "</td>";

                            echo "<td id='totalPrice".$i."'>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='button' id='save".$i."' onClick='vetSave(".$i.",&quot;".$date."&quot;)' value='Agendar'/>";
                            echo "</td>";

                            echo "</tr>";
                            
                        }else{
                            foreach($vetList as $vet){
                               
                                $service = $vet->servic->nameServic;

                                $bgColor = '';
                                if($vet->status == 2){
                                    $bgColor = "style='background: rgba(255, 0, 0, 0.6);'";
                                }else if($vet->status == -1){                                                                        
                                    $bgColor = "style='background: rgba(255, 0, 0, 0.6);'";
                                }else if($vet->status == 1){
                                    $bgColor = "style='background: rgba(24,202,39,0.6);'";
                                }else if($vet->status == 0){
                                    $bgColor = "style='background: rgba(222,217,8,0.6);'";
                                }
                                echo "<tr ".$bgColor." id='tr".$vet->idVet."' onClick='vetPositionRow(this);'>";

                                $dHour = new DateTime($vet->dateHour);
                                $dHourShow = $dHour->format('H:i');
                                echo "<td id='hour_".$vet->idVet."' onClick='vetAddRow(&quot;".$dHourShow."&quot; , &quot;".$date."&quot;);'>";
                                echo $dHourShow;
                                echo "</td>";

                                echo "<td>";
                                echo "<input type='text' id='nameAnimal_".$vet->idVet."' name='nameAnimal' class='form-control nameAnimal' value='".$vet->client->nameAnimal."' readonly>";
                                echo "</td>";

                                echo "<td>";
                                echo $vet->client->breed->nameBreed;
                                echo "</td>";

                                echo "<td>";
                                echo $vet->client->owner;
                                echo "</td>";

                                echo "<td>";
                                if($vet->search == 1){
                                    echo"<input type='checkbox' id='search_".$vet->idVet."' name='search' value='1' class='form-control' disabled checked>";
                                }else{
                                    echo"<input type='checkbox' id='search_".$vet->idVet."' name='search' value='1' class='form-control' disabled>";
                                }
                                echo "</td>";

                                echo "<td id='tdAddress_".$vet->idVet."'>";
                                if($vet->search == 1)
                                    echo $vet->client->addressNumber;
                                 else
                                    echo "<input type='hidden' id='address_".$vet->idVet."' value='".$vet->client->addressNumber."' >";
                                echo "</td>";

                                echo "<td id='tdDistrict_".$vet->idVet."'>";
                                if($vet->search == 1)
                                    echo $vet->client->address->district;
                                else
                                    echo "<input type='hidden' id='district_".$vet->idVet."' value='".$vet->client->address->district."' >";
                                echo "</td>";

                                echo "<td>";
                                echo $vet->client->phone1;
                                echo "</td>";

                                echo "<td>";
                                echo $vet->client->phone2;
                                echo "</td>";
                                
                                echo "<td>";
                                echo "<div id='servicWithFieldEdit".$vet->idVet."' style='display:none'>";
                                echo "<select id='serviceSelect_".$vet->idVet."' name='service' class='form-control' onChange='vetSelectValuation(this.value,".$vet->idVet." );' >";
                                foreach($servicList as $servic){
                                    if($servic->idServic == $vet->servic->idServic){
                                        echo "<option value=".$servic->idServic." selected>".$servic->nameServic."</option>";
                                    }else{
                                        echo "<option value=".$servic->idServic.">".$servic->nameServic."</option>";
                                    }
                                }
                                echo "</select>";
                               
                                echo "</div>";

                                echo "<div id='servicWithoutFieldEdit".$vet->idVet."'>";
                                echo $service;
                                echo "</div>";
                                echo "</td>";

                                echo "<td>";
                                echo $vet->price;
                                echo "</td>";

                                echo "<td id='tdDeliveryPrice_".$vet->idVet."'>";
                                if($vet->deliveryPrice > 0)
                                    echo $vet->deliveryPrice;
                                else
                                    echo "<input type='hidden' id='deliveryPrice_".$vet->idVet."' onBlur='vetCalcGross();' value='".$addressArray[$vet->client->address->idAddress]."' >";
                                echo "</td>";

                                echo "<td>";
                                $totalPriceC = 0;
                                echo $vet->totalPrice + $totalPriceC;
                                echo "</td>";

                                echo "<td id='status".$vet->idVet."' >";
                                if($vet->status == 2){
                                    echo "Finalizado";
                                }else if($vet->status == -1){
                                    echo "Cancelado";
                                }else if($vet->status == 1){
                                    echo "<input type='button' onClick='vetFinish(".$vet->idVet.",2);' value='Finalizar'/>";
                                    echo "<input type='button' onClick='dataToModal(".$vet->idVet.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
                                    echo "<br><input type='button' onClick='canc(".$vet->idVet.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                }else if($vet->status == 0){
                                    echo "<input type='button' onClick='vetFinish(".$vet->idVet.",1);' value='Check-in'/>";
                                    echo "<input type='button' onClick='vetPayAnticipate(".$vet->idVet.");' value='Pagar'/>";
                                    echo "<br><input type='button' onClick='canc(".$vet->idVet.");' data-toggle='modal' data-target='#modalCanc' value='Cancelar'/>";
                                    echo "<input type='button' onClick='dataToModal(".$vet->idVet.",&quot;".$dHourShow."&quot;,&quot;".$date."&quot;);' data-toggle='modal' data-target='#modalEdit' value='Editar'/>";
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
                        <h4 class="modal-title">Cancelar</h4>
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
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="vetFinish(0,-1);">Confirmar</button>                        
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
                        <h4 class="modal-title">Editar</h4>
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
                            <button type="button" class="btn btn-success" data-dismiss="modal" onClick="vetActiveFiedsForUpdate();" >Confirmar</button>                        
                        </div>
                    </div>
                    
                    </div>
                </div><!--Fim Modal Edição-->

                
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
***Status Vet***
    Cancelado = -1
    Agendadao = 0
    Presente = 1
    Finalizado = 2
-->