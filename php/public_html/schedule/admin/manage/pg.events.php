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

/* Demo Check */
if(!isDemo('bulkDel')){$errText = errMod(calglb_demo_mode_active,'danger');}
$errText = '';

# Bulk Deletion
if(isset($_POST['bulkDel'])){
	if(isset($_POST['del'])){
		foreach($_POST['del'] as $k=>$v){
			if(CAL_VIEW_MODE){$db->where('user_id',CAL_AUTH_ID);}
			$db->where('note_id=?',array($v));
			$db->delete('panel_notes');
		}
	}
}
?>
<!-- PAGE NAVIGATION START -->
<div>
	<h3 class="no-margin pg-head"></h3><span class="clearfix"></span>
	<hr>
</div>
<!-- PAGE NAVIGATION END -->
<!-- EVENTS START -->
<?php
$src = ((isset($_GET['sv'])) ? $_GET['sv']:'');

if(isset($_GET['dfrom'])){
	$_GET['dfrom'] = urldecode($_GET['dfrom']);
	$dfrom = DateTime::createFromFormat("d/m/Y", $_GET['dfrom'])->format("Ymd");
}else{
	$_GET['dfrom'] = date('01/m/Y');
	$dfrom = DateTime::createFromFormat("d/m/Y", $_GET['dfrom'])->format("Ymd");
}

if(isset($_GET['dto'])){
	$_GET['dto'] = urldecode($_GET['dto']);
	$dto = DateTime::createFromFormat("d/m/Y", $_GET['dto'])->format("Ymd");
}else{
	$_GET['dto'] = date('t/12/Y');
	$dto = DateTime::createFromFormat("d/m/Y", $_GET['dto'])->format("Ymd");
}

//echo($dto);

$expRange = date('Y-m-d H:i');
$limit = 15;
$cols = array('note_id','user_id','mynotes','title','add_date','note_date','note_icon','note_color');
$pgGo = ((!isset($_GET["pgGo"]) || !is_numeric($_GET["pgGo"])) ?  1:intval($_GET["pgGo"]));
$dtStart	 = ($pgGo-1)*$limit;

# Auth
if(CAL_VIEW_MODE){$db->where('user_id',CAL_AUTH_ID);}

# Search Value
if($src!=''){
	$db->where("title LIKE ? OR mynotes LIKE ?",array('%'.$src.'%','%'.$src.'%'));
}

# Date Conbination
$db->where("DATE_FORMAT(note_date,'%Y%m%d') BETWEEN ? AND ?",array($dfrom,$dto));

$getList = $db->withTotalCount()->orderBy('note_date','ASC')->get('panel_notes',array($dtStart,$limit),$cols);
$count = $db->totalCount;
$total_page	 = ceil($count / $limit);
?>
			<div class="row">
				<div class="col-md-12 table-responsive">
					<div class="row">
						<div class="col-md-8">
							<form action="?p=events" method="GET" class="form-inline">
								<input type="hidden" name="p" value="events">
								<div class="form-group">
									<input type="text" class="form-control input-sm" id="sv" name="sv" placeholder="<?php echo(calglb_search);?>" value="<?php echo(showIn($src,'input'));?>"> 
								</div>
								<div class="form-group">
									<label for="dfrom"><?php echo(calglb_start);?></label>
									<input type="text" class="form-control input-sm srcdp" id="dfrom" name="dfrom" value="<?php echo(showIn(date('d/m/Y',strtotime($dfrom)),'input'));?>"> 
								</div>
								<div class="form-group">
									<label for="dto"><?php echo(calglb_end);?></label>
									<input type="text" class="form-control input-sm srcdp" id="dto" name="dto" value="<?php echo(showIn(date('d/m/Y',strtotime($dto)),'input'));?>"> 
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-search"></i></button>
								</div>
							</form>
						</div>
						<div class="col-md-4">
							<span class="pagination-mirror"></span><span class="clearfix"></span>
						</div>
					</div><hr>
					<form name="remList" id="remList" action="" method="POST">
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th width="2%"><input type="checkbox" name="checkAll" id="checkAll" class="iCheck"></th>
								<th><?php echo(calglb_title);?></th>
								<th><?php echo(calglb_date);?></th>
								<th><?php echo(calglb_added);?></th>
								<th><?php echo(calglb_author);?></th>
							</tr>
						</thead>
						<tbody>
						<?php if($db->count==0){echo('<tr><td colspan="5">'. errMod(calglb_record_not_found,'danger') .'</td></tr>');}else{
						foreach($getList as $getLists){
						?>
							<tr>
								<td><input type="checkbox" name="del[]" id="del<?php echo($getLists['note_id']);?>" value="<?php echo($getLists['note_id']);?>" class="iCheck checkRow"></td>
								<td><a href="javascript:;" data-fancybox-href="<?php echo(getSEO($getLists['note_id'],$getLists['title']));?>" data-fancybox-type="iframe" <?php echo(((date('Y-m-d H:i',strtotime($getLists['note_date'])) < date('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"'));?>><?php echo(showIn($getLists['title'],'page'));?></a></td>
								<td><?php echo(setMyDate($getLists['note_date'],2));?></td>
								<td><?php echo(setMyDate($getLists['add_date'],2));?></td>
								<td><?php echo(getUser($getLists['user_id'],1));?></td>
							</tr>
						<?php }}?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5">
									<button type="submit" name="bulkDel" id="bulkDel" class="btn btn-danger btn-sm"><?php echo(calglb_delete);?></button>
									<?php $pgPos=true; $pgVar='?p=events&amp;sv='. urlencode($src) .'&amp;dfrom='. urlencode(date('d/m/Y',strtotime($dfrom))) .'&amp;dto='.urlencode(date('d/m/Y',strtotime($dto))) .''; include_once('inc/inc_pagination.php');?>
								</th>
							</tr>
						</tfoot>
					</table>
					</form>
				</div>
			</div>
			
<script>
$(document).ready(function(){
	pgTitleMod('<?php echo(calglb_events);?>');
	
	$("#bs-navbar-collapse-1 ul.nav li").removeClass('active');
	$(".navb-events").addClass('active');
	
	/* Datepicker */
	$(".srcdp").datepicker({
		dateFormat: 'dd/mm/yy'
	});
	
	/* Confirmation */
	$("#remList").submit(function(e){
		
		if($(".checkRow:checked").length<1){
			alert('<?php echo(calglb_please_choose_a_event);?>');
			e.preventDefault();
		}else{
			if(!confirm('<?php echo(calglb_are_you_sure_to_remove_selected_entries);?>')){
				e.preventDefault();
			}
		}
	});
});
</script>
<!-- EVENTS END -->