<!DOCTYPE html>
<html lang='PT-BR'>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</head>
<body>

	<div id='calendar'></div>

</body>
</html>
<script src='../fullcalendar/lib/moment.min.js'></script>
<script src='../fullcalendar/lib/jquery.min.js'></script>
<script src='../fullcalendar/fullcalendar.min.js'></script>
<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			defaultDate: new Date(),
			locale: 'pt-br',
			editable: true,
			eventLimit: true, 
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				var dateSelected = new Date(end);
				param = dateSelected.getFullYear()+'-'+(dateSelected.getMonth()+1)+dateSelected.getDate();
				location.assign('/bichoensaboado/view/index.php?date='+param);
			},
			
		});
		
	});

</script>