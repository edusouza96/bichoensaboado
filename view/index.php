<?php
    $date = $_GET['date'];
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../dao/DiaryDAO.php");
    $diaryDao = new DiaryDAO();
    $clientDao = new ClientDAO();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda Pet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script>
            $(function(){
                $(".nameAnimal").autocomplete({
                    source: <?php 
                                echo json_encode($clientDao->SearchName());
                            ?>
                });
            });
        </script>
       
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

                            echo "<td onClick='addRow(&quot;".$hour."&quot;);'>";
                            echo $hour;
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='text' id='nameAnimal' name='nameAnimal' class='form-control nameAnimal'>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "<button type='button' class='btn btn-default' data-toggle='modal' data-target='#modalOwner'>Selecionar Dono</button>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='checkbox' id='search' name='search' value='1' class='form-control'>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";
                            
                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='text' id='price' name='price' onChange='totalPrice(this.value, &quot;price&quot;);' class='form-control'>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='text' id='deliveryPrice' name='deliveryPrice' onChange='totalPrice(this.value, &quot;deliveryPrice&quot;);' class='form-control'>";
                            echo "</td>";

                            echo "<td>";
                            echo "</td>";

                            echo "<td>";
                            echo "<input type='button' value='Agendar'/>";
                            echo "</td>";

                            echo "</tr>";
                            
                        }else{
                            foreach($diaryList as $diary){
                                echo "<tr onClick='positionRow(this);'>";

                                $dHour = new DateTime($diary->dateHour);
                                $dHourShow = $dHour->format('H:i');
                                echo "<td onClick='addRow(&quot;".$dHourShow."&quot;);'>";
                                echo $dHourShow;
                                echo "</td>";

                                echo "<td>";
                                echo "<input type='text' id='nameAnimal' name='nameAnimal' class='form-control nameAnimal' value='".$diary->client->nameAnimal."' rezadonly>";
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->breed->nameBreed;
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->owner;
                                echo "</td>";

                                echo "<td>";
                                if($diary->search == 1){
                                    echo"<input type='checkbox' id='search' name='search' value='1' class='form-control' checked>";
                                }else{
                                    echo"<input type='checkbox' id='search' name='search' value='1' class='form-control'>";
                                }
                                echo "</td>";

                                echo "<td>";
                                echo $diary->client->address->street;
                                echo "</br>N°".$diary->client->addressNumber;
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

                                echo "<td>";
                                echo "<input type='button' value='Finalizar'/>";
                                echo "</td>";

                                echo "</tr>";
                                
                            }
                        }
                        $hour =  date('H:i', strtotime('+30 minute', strtotime($hour)));
                    }                        
                ?>
                
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="modalOwner" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Escolher Dono</h4>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Eduardo Souza</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Edu Silva</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    function addRow(hour){
        setTimeout(function () {
            var pRow = window.sessionStorage.getItem('pRow');
            var table=document.getElementById('tableDiary');
            var row=table.insertRow(pRow);
            console.log(row);
            var colCount=table.rows[0].cells.length;
            row.setAttribute("onClick", "positionRow(this);");
            for(var i=0;i<colCount;i++){
                var newcell=row.insertCell(i);
                
                if (i == 0) {
                    newcell.innerHTML = hour;
                    newcell.setAttribute('onClick', "addRow('"+hour+"');");
                }else if (i == 1){
                    newcell.innerHTML = "<input type='text' id='nameAnimal' name='nameAnimal' class='form-control nameAnimal'>";
                }else if( i==4){
                    newcell.innerHTML = "<input type='checkbox' id='search' name='search' value='1' class='form-control'>";
                } 

            }
        }, 1000)
    }

    function positionRow(pRow) {
        window.sessionStorage.setItem('pRow', (pRow.rowIndex+=1));
    }

    function totalPrice(pValue,pText) {
        setTimeout(function () {
            var pRow = parseInt(window.sessionStorage.getItem('pRow')) -1;
            var row=document.getElementById('tableDiary').getElementsByTagName("tr");
            var cells = row[pRow].getElementsByTagName("td");
            window.sessionStorage.setItem( pText+pRow, pValue);
            var pPrice = window.sessionStorage.getItem('price'+pRow);
            var pDeliveryPrice = window.sessionStorage.getItem('deliveryPrice'+pRow);
            cells[12].innerHTML = parseFloat(pPrice) + parseFloat(pDeliveryPrice);
        }, 1000)

    }
</script>