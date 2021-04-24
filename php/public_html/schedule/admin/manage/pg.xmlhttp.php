<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 15.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once('../../caledonian.php');
$pos = ((!isset($_GET['pos']) || $_GET['pos']=='') ? '':trim($_GET['pos']));

# Load Widget Fields
if($pos=='getFields'){
	
	if(!isset($_POST['widType']) || !array_key_exists($_POST['widType'],$CAL_WIDGETS)){
		die('Widget Error!');
	}else{
		$loader = '';
		$wid = new caledonian();
		$wid->widgetType = $_POST['widType'];
		$loader.=$wid->WidgetFields();
		$loader.='
			<script>
				$("#widgetInfo").html("");
				$("#widgetInfo").append("<h3>'. $CAL_WIDGETS[$_POST['widType']]['name'] .'</h3>");
				$("#widgetInfo").append("<div class=\"alert alert-info\">'. $CAL_WIDGETS[$_POST['widType']]['info'] .'</div>");
				$("#widgetInfo").append("<img src=\"'. $CAL_WIDGETS[$_POST['widType']]['preview'] .'\">");
				// iCheck
				$(".iCheck").iCheck({
					checkboxClass: "icheckbox_flat-red",
					radioClass: "iradio_flat-red"
				});
			</script>
		';
		die($loader);
	}
}
?>