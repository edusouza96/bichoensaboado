<?php
    include_once("ClientDAO.php");

	$nameAnimal = 'Scooby';//mysql_real_escape_string( $_REQUEST['nameAnimal'] );
    $list = array();
	$clientDao = new ClientDAO();
    $list = $clientDao->SearchOwner($nameAnimal);
	echo( json_encode( $list ) );
    
