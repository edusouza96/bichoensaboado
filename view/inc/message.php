<div id="alert" class="alert danger col-xs-12 col-sm-12 col-lg-12 col-md-12">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <p id="msg-alert" class="col-xs-offset-4 col-sm-offset-4 col-lg-offset-5 col-md-offset-5"><?=getMessage($_GET['code'])?></p>
</div>

<style>
.cursor-link{
    cursor:pointer;
}

.alert {
    padding: 10px;
    background-color: #f44336;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
<?php

    function getMessage($code){
        switch ($code) {
            case '400-l':
                return 'Login Inválido!';

            case '401-l':
                return 'Acesso Negado!';
        }
    }
?>