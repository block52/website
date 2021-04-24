<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">Upcoming Events</div>
			<div class="panel-body">
				<div id="widget_area"></div>
			</div>
		</div>
		<script src="http://caledonian.artlantis.net/valve/Scripts/jquery-1.11.3.min.js"></script><link rel="stylesheet" href="http://caledonian.artlantis.net/valve/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="http://caledonian.artlantis.net/valve/bootstrap/css/flatly_bootstrap.min.css"><script src="http://caledonian.artlantis.net/valve/bootstrap/js/bootstrap.min.js"></script><link href="http://caledonian.artlantis.net/valve/css/jquery-ui.min.css" rel="stylesheet"><link href="http://caledonian.artlantis.net/valve/css/jquery-ui.theme.min.css" rel="stylesheet"><script src="http://caledonian.artlantis.net/valve/Scripts/jquery-ui.min.js"></script><script src="http://caledonian.artlantis.net/valve/Scripts/dp_lang/en.js"></script><link href="http://caledonian.artlantis.net/valve/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" /><script src="http://caledonian.artlantis.net/valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script><div id="widget_area"></div><script> $(document).ready(function(){ $.ajax({ url : "http://caledonian.artlantis.net/widget.php?wk=c63c8dfd862389c7d5fa01d212ce4865", type: "GET", contentType: "application/x-www-form-urlencoded", success: function(data, textStatus, jqXHR) { $("#widget_area").html(data); }, error: function (jqXHR, textStatus, errorThrown) { $("#widget_area").html('Error Occured!'); } }); }); </script>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Widget Info AJAX</div>
			<div class="panel-body">
				<ul>
					<li>Ajax controlled upcoming event lister</li>
					<li>List count could be set</li>
					<li>Event detail modal</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">Upcoming Events</div>
			<div class="panel-body">
				<iframe id="c63c8dfd862389c7d5fa01d212ce4865" style="width:100%; height:300px; border:0;" frameborder="0" src="http://caledonian.artlantis.net/widget.php?wk=c63c8dfd862389c7d5fa01d212ce4865"></iframe>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Widget Info IFRAME</div>
			<div class="panel-body">
				<ul>
					<li>Iframe controlled upcoming event lister</li>
					<li>List count could be set</li>
					<li>Event detail modal</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#bs-navbar-collapse-1 li").removeClass('active');
		$("#bs-navbar-collapse-1 li.wid3").addClass('active');
	});
</script>