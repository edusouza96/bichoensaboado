<?
    $hour = $_GET['hour'];
    $date = $_GET['date'];
    $dateTime = $date." ".$hour;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/bootstrap-3.3.7-dist/css/bootstrap.css">
       <script language="javascript" src="ajax.js"></script>
       <script language="javascript" src="ajaxComplete.js"></script>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Registrar horário</h2>
        </div>
        <form action="index1.php" method="POST">
            <input type="hidden" name="dataHour" value="<?=$dateTime?>" > 
            <div class="container">
                <div class="row"> 
                    <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1"><!--div hour-->
                        <div class="form-group"> 
                            <label for="hour">Hora</label>
                            <input type="text" id="hour" name="hour" value="<?=$hour ?>" class="form-control" disabled>
                        </div>
                    </div><!--end div hour-->
                
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><!--div name animal-->
                        <div class="form-group"> 
                            <label for="nameAnimal">Nome do Animal</label>
                            <input type="text" id="nameAnimal" name="nameAnimal" onBlur="jsSearchAnimal(this.value)" class="form-control">
                            <div id="nome"></div>
                        </div>
                    </div><!-- end div name animal-->

                
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div line breed-->
                        <div class="form-group"> 
                            <label for="breed">Raça</label>
                            <input type="text" id="breed" name="breed" class="form-control">
                        </div>
                    </div>
                </div><!-- end div line breed-->

                <div class="row"> <!--div line owner-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div class="form-group"> 
                            <label for="owner">Proprietário</label>
                            <select id="owner" name="owner" onBlur="jsCompleteFull(this.value)" class="form-control">
                                <option value="vazio">Selecione</option>
                            </select>
                        </div>
                    </div>
                </div><!-- end div line owner-->

                <div class="row"> 
                    <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1"><!--div search-->
                        <div class="form-group"> 
                            <label for="search">Busca <input type="checkbox" id="search" name="search" value="1" class="form-control"></label>                        
                        </div>
                    </div><!-- end search-->

                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div address-->
                        <div class="form-group"> 
                            <label for="address">Endereço</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                    </div><!-- end div address-->

                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div district-->
                        <div class="form-group"> 
                            <label for="district">Bairro</label>
                            <input type="text" id="district" name="district" class="form-control">
                        </div>
                    </div><!-- end div district-->
                </div>

                <div class="row"> 
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><!--div phone1-->
                        <div class="form-group"> 
                            <label for="phone1">Telefone 1</label>
                            <input type="text" id="phone1" name="phone1" class="form-control">
                        </div>
                    </div><!-- end div phone1-->

                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><!--div phone2-->
                        <div class="form-group"> 
                            <label for="phone2">Telefone 2</label>
                            <input type="text" id="phone2" name="phone2" class="form-control">
                        </div>
                    </div><!-- end div phone2-->
                </div>

                <div class="row"> 
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div service-->
                        <div class="form-group"> 
                            <label for="service">Serviço</label>
                            <select id="service" name="service" class="form-control">
                                <option value="banho">Banho</option>
                                <option value="banhoTosa">Banho+Tosa</option>
                            </select>
                        </div>
                    </div><!-- end div service-->

                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div line price-->
                        <div class="form-group"> 
                            <label for="price">Valor</label>
                            <input type="text" id="price" name="price" value=0 onChange="jsTotalPrice()" class="form-control">
                        </div>
                    </div><!-- end div price-->
                
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div delivery price-->
                        <div class="form-group"> 
                            <label for="deliveryPrice">Taxa de Entrega</label>
                            <input type="text" id="deliveryPrice" value=0 name="deliveryPrice" onChange="jsTotalPrice()"class="form-control">
                        </div>
                    </div><!-- end div delivery price-->
                </div>

                <div class="row"> 
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div total price-->
                        <div class="form-group"> 
                            <label for="totalPrice">Total</label>
                            <input type="text" id="totalPrice" name="totalPrice" class="form-control" readonly="readonly">
                        </div>
                    </div><!-- end div total price-->

                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><!--div payment-->
                        <div class="form-group"> 
                            <label for="payment">Forma de Pagamento</label>
                            <select id="payment" name="payment" class="form-control">
                                <option value="dinheiro">Dinheiro</option>
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                            </select>
                        </div>
                    </div><!--end div payment-->
                </div>
                <div class="row"> <!--div button-->
                    <div class="col-xs-8 col-sm-8 col-lg-8 col-md-82">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Agendar</button>
                        </div>
                    </div>
                </div><!-- end div button-->

            </div>
            
        </form>
    </body>
</html>


<script>
function jsTotalPrice() {
    var price = parseFloat(document.getElementById('price').value);
    var deliveryPrice = parseFloat(document.getElementById('deliveryPrice').value);
    document.getElementById('totalPrice').value = price + deliveryPrice;
}

function jsSearchAnimal() {
    var nameAnimal = document.getElementById("nameAnimal");
    url = "searchAnimal.php?nameAnimal=" + nameAnimal.value; 
    ajax(url, 'nome');
}

function jsCompleteFull() {
    var owner = document.getElementById("owner");
    url = "completeFull.php?owner=" + owner.value; 
    ajaxComplete(url, 'nome');
}
</script>

<?
require_once("ConexaoMysql.php");
$mySQL = new MySQL;
$sql = "Insert into diary values 
    (0,'$_POST[dataHour]','$_POST[nameAnimal]','$_POST[breed]', '$_POST[owner]', '$_POST[search]', '$_POST[address]','$_POST[district]','$_POST[phone1]','$_POST[phone2]','$_POST[service]', '$_POST[price]', '$_POST[deliveryPrice]', '$_POST[totalPrice]','$_POST[payment]')";
$rs = $mySQL->executeQuery($sql);

$mySQL->disconnect();
?>