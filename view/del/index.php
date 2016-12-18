
<?
require_once("ConexaoMysql.php");
$date = $_GET['date'];;
/*$mySQL = new MySQL;
$rs = $mySQL->executeQuery("SELECT * FROM diary;");
$mySQL->disconnect();*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script type="text/javascript" src="js1.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
       
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Horários</h2>
        </div>
        <table border="1" class="table table-condensed table-striped table-bordered table-hover">
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
                    <th>Forma de pagamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?
                   /*
                    $rs = select();
                    while ($field = mysql_fetch_array($rs)){
                        
                        $date = date_create($field[1]);
                        if($field[5]==1){
                            $search = 'Sim';
                        }else{
                            $search = 'Não';
                        }

                        echo "
                            <tr>
                                <td><a href='index1.php?date=$field[1]'>".date_format($date, 'H:i')."</a></td>
                                <td><input type='text' id='nameAnimal' name='nameAnimal' class='form-control'></td>
                                <td>".$field[3]."</td>
                                <td>".$field[4]."</td>
                                <td>".$search."</td>
                                <td>".$field[6]."</td>
                                <td>".$field[7]."</td>
                                <td>".$field[8]."</td>
                                <td>".$field[9]."</td>
                                <td>".$field[10]."</td>
                                <td>R$ ".$field[11]."</td>
                                <td>R$ ".$field[12]."</td>
                                <td>R$ ".$field[13]."</td>
                                <td>".$field[14]."</td>
                            </tr>";
                    }
                  */

                    $hour = '08:00';
                    for($i =1; $i < 20; $i++){
                        $rs = select($date, $hour);
                        $numberRows = mysql_num_rows($rs); 
                        
                        while ($row = mysql_fetch_array($rs)){
                            $field = $row;
                            
                            if($field[5]==1){
                                $search = 'Sim';
                            }else{
                                $search = 'Não';
                            }
                            
                            echo "
                            <tr>
                                <td>$hour</td>
                                <td><input type='text' id='nameAnimal' name='nameAnimal' class='form-control'></td>
                                <td>".$field[3]."</td>
                                <td>".$field[4]."</td>
                                <td>".$search."</td>
                                <td>".$field[6]."</td>
                                <td>".$field[7]."</td>
                                <td>".$field[8]."</td>
                                <td>".$field[9]."</td>
                                <td><select id='service' name='service' class='form-control'>
                                <option value='banho'>Banho</option>
                                <option value='banhoTosa'>Banho+Tosa</option>
                            </select></td>
                                <td>R$ ".$field[11]."</td>
                                <td>R$ ".$field[12]."</td>
                                <td>R$ ".$field[13]."</td>
                                <td>".$field[14]."</td>
                            </tr>";
                            $field = '';
                            $search = '';
                        }
                    
                        while ($numberRows != 4){
                            $nameId = '"'.$hour.''.$numberRows.'"';
                            echo "
                            <tr>
                                <td>$hour</td>
                                <td><input type='text' id='nameAnimal' name='nameAnimal' class='form-control'></td>
                                <td></td>
                                <td></td>
                                <td><div id=".$nameId." onclick='myFunction(".$nameId.")'><img src='nok.png'/>.</div></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><select id='service' name='service' class='form-control'>
                                <option value='banho'>Banho</option>
                                <option value='banhoTosa'>Banho+Tosa</option>
                            </select></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button onclick='AddTableRow()' type='button'>Adicionar Produto</button></td>
                            </tr>";
                            $numberRows++;
                        }
                    
                        $hour =  date('H:i', strtotime('+30 minute', strtotime($hour)));
                    }
                        
                ?>
                
            </tbody>
        </table>
    </body>
</html>
<?
    function select($date, $hour){
        $dateTime = $date." ".$hour.":00";
        $mySQL = new MySQL;
		$rs = $mySQL->executeQuery("SELECT * FROM diary where dateHour = '".$dateTime."';");
		$mySQL->disconnect();
		return $rs;
    }
?>
<script>
function myFunction(nameId) {
    var oldInfo = document.getElementById(nameId).innerHTML;
    var obj= document.getElementById(nameId);
    
    if(oldInfo == ".."){
        document.getElementById(nameId).innerHTML = ".";
        obj.style.backgroundImage="url(nok.png)";
    }else{
        document.getElementById(nameId).innerHTML = "..";
        obj.style.backgroundImage="url(ok.png)";
    }
    
}
</script>