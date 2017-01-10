<?php
    $date = $_GET['date'];
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
        <script language="javascript" src="../js/ajax.js?v=2"></script>
        <script language="javascript" src="../js/functionsDiary.js?v=2"></script>
        
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Horários</h2>
        </div>
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
                                echo "<tr onClick='positionRow(this);'>";

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
                                echo $diary->client->addressNumber;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->address->district;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone1;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->phone2;
                                echo "</td>";
                                
                                echo "<td>";
                                echo $diary->servic->nameServic;
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
                                if($diary->status == 1){
                                    echo "Finalizado";
                                }else{
                                    echo "<input type='button' onClick='finish(".$diary->idDiary.");' value='Finalizar'/>";
                                }
                                echo "</td>";

                                echo "</tr>";
                                
                            }
                        }
                        $hour =  date('H:i', strtotime('+30 minute', strtotime($hour)));
                    }                        
                ?>
                
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