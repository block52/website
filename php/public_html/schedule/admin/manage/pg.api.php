<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 03.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
if(!$master_conn){die('<strong style="color:red;">Access denied</strong> - You are not authorized to access this page!');}
if(CAL_AUTH_MODE!=1){die('<strong style="color:red;">Access denied</strong> - You are not authorized to access this page!');}
?>
<!-- API START -->
<!-- PAGE NAVIGATION START -->
<div>
	<h3 class="no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->

<script>
$(document).ready(function(){
	pgTitleMod('API');
	
	$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
	$(".navAdmn").addClass('active');
	
});
</script>
<!-- API END -->