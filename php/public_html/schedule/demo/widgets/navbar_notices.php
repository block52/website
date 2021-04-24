<style>
div#fancy_outer {
z-index: 1000000;
}
</style>
<link rel="stylesheet" href="http://caledonian.artlantis.net/valve/widgets/css/navbar_notices.css">
<div class="row">
	<div class="col-md-12">

		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Brand</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Link</a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">One more separated link</a></li>
				  </ul>
				</li>
			  </ul>
			  <form class="navbar-form navbar-left" role="search">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			  </form>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="#">Link</a></li>
				<li class="caledonian dropdown"></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Separated link</a></li>
				  </ul>
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	
	</div>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Widget Info</div>
			<div class="panel-body">
				<ul>
					<li>Bootstrap Navbar Notification</li>
					<li>Simple Ajax Call</li>
					<li>Customizable Sound Effect</li>
					<li>Animated Bar Item</li>
					<li>Custom Refresh Time</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script src="http://caledonian.artlantis.net/valve/Scripts/jquery-1.11.3.min.js"></script><link rel="stylesheet" href="http://caledonian.artlantis.net/valve/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="http://caledonian.artlantis.net/valve/bootstrap/css/flatly_bootstrap.min.css"><script src="http://caledonian.artlantis.net/valve/bootstrap/js/bootstrap.min.js"></script><link href="http://caledonian.artlantis.net/valve/css/jquery-ui.min.css" rel="stylesheet"><link href="http://caledonian.artlantis.net/valve/css/jquery-ui.theme.min.css" rel="stylesheet"><script src="http://caledonian.artlantis.net/valve/Scripts/jquery-ui.min.js"></script><script src="http://caledonian.artlantis.net/valve/Scripts/dp_lang/en.js"></script><link href="http://caledonian.artlantis.net/valve/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" /><script src="http://caledonian.artlantis.net/valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script><script src="http://caledonian.artlantis.net/valve/widgets/scripts/buzz.min.js"></script><div id="widget_area"></div><script> $(document).ready(function(){ $.ajax({ url : "http://caledonian.artlantis.net/widget.php?wk=5d3e837e508de2b9e914aee6aaaf3959", type: "GET", contentType: "application/x-www-form-urlencoded", success: function(data, textStatus, jqXHR) { $(".caledonian").html(data); }, error: function (jqXHR, textStatus, errorThrown) { $(".caledonian").html(''); } }); }); </script>

<script>
	$(document).ready(function(){
		$("#bs-navbar-collapse-1 li").removeClass('active');
		$("#bs-navbar-collapse-1 li.wid5").addClass('active');
	});
</script>