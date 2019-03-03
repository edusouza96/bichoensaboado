<?php
if($_SERVER['SERVER_NAME'] == 'localhost'){
	$urlBase = "http://".$_SERVER['SERVER_NAME']."";
}else{
	$urlBase = "http://".$_SERVER['SERVER_NAME'];
}

session_start();
if(empty($_SESSION["userOnline"])){
	header("location:$urlBase/bichoensaboado/view/login/index.php");  
}
?>
<!DOCTYPE html>
<html lang='PT-BR'>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<link href='../fullcalendar/bootstrap.min.css' rel="stylesheet">

<style>

	body {
		/* margin: 40px 10px; */
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 800px;
		margin: 0 auto;
	}
}

</style>
</head>
<body>
	<div class="jumbotron"> 
		<h2>Agenda Pet</h2>
	</div>
	<div class="container">
		<div id='calendar'></div>
	</div>
</body>
</html>
<script src='../fullcalendar/lib/moment.min.js'></script>
<script src='../fullcalendar/lib/jquery.min.js'></script>
<script src='../fullcalendar/fullcalendar.min.js'></script>
<script src='../fullcalendar/locale-all.js'></script>
<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			themeSystem: 'bootstrap3',
			defaultDate: new Date(),
			locale: 'pt-br',
			editable: true,
			eventLimit: true, 
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				var dateSelected = new Date(end);
				var year = dateSelected.getFullYear();
				var month = dateSelected.getMonth()+1;
				if(month < 10)
					month = '0'+month;
				var day = dateSelected.getDate();
				if(day < 10)
					day = '0'+day;

				param = year+'-'+month+'-'+day;
				location.assign('/bichoensaboado/view/index.php?date='+param);
			},
			
		});
		
	});

</script>