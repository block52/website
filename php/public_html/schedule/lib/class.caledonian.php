<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 30.06.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
class caledonian{
	
	public $calDate = null;
	public $isAdmin = false;
	public $navigation = true;
	public $element = '#sdr-calendar';
	public $day = null;
	public $month = null;
	public $year = null;
	public $mailReceiver = null;
	public $errPrint = '';
	public $onInstall = false;
	public $widgetFieldData = array();
	public $widgetType = '';
	public $widgetOn = 0;
	public $widgetUser = 0; # 0 - All Users, x - Specific User
	public $widgetFetchData = 1; # 0 - Private, 1 - Public, 2 - All
	public $widgetDataCount = 5;
	public $widgetDataPg = 1;
	public $widgetKey = '';
	public $widgetEdit = false;
	public $widgetEditData = array();
	
	# Draw Calendar
	public function drawCal(){
		
		global $db;
		global $CAL_DATE_VALUES;
		
		if($this->day==null){$this->day = demoDate('d');}
		if($this->month==null){$this->month = demoDate('m');}
		if($this->year==null){$this->year = demoDate('Y');}
		
		if($this->calDate==null){
			$this->calDate = $this->year.'-'.$this->month.'-'.$this->day;
		}
	
		$calendar = '';
		
		# PREPARE TASKS
		$calDatas = array();
		
		$addParam = array(
							'w'=>0,
							'u'=>'-',
							'fd'=>2
						);
		
		# Widget Settings
		if($this->widgetOn){
			$addParam['w']=1;
			if($this->widgetUser!=0){
				$addParam['u']=getUser($this->widgetUser,2);
				$db->where("(user_id=?) AND DATE_FORMAT(note_date,'%Y-%m')=?",array($this->widgetUser,date('Y-m',strtotime($this->calDate))));
			}else{
				$db->where("DATE_FORMAT(note_date,'%Y-%m')=?",array(date('Y-m',strtotime($this->calDate))));
			}
			if($this->widgetFetchData!=2){
				$addParam['fd']=$this->widgetFetchData;
				$db->where('data_type',$this->widgetFetchData);
			}
		}else{
			if(isLogged()){
				# Admin Based
				if(!$this->isAdmin){
					$db->where("(user_id=? OR user_id=?) AND DATE_FORMAT(note_date,'%Y-%m')=?",array(CAL_AUTH_ID,0,date('Y-m',strtotime($this->calDate))));
				}else{
					$db->where("DATE_FORMAT(note_date,'%Y-%m')=?",array(date('Y-m',strtotime($this->calDate))));
				}
			}else{
				# Public Area
				$db->where("DATE_FORMAT(note_date,'%Y-%m')=?",array(date('Y-m',strtotime($this->calDate))));
			}
		}
		
		
		$db->orderBy('note_date','ASC');
		$data = $db->get('panel_notes');
		foreach($data as $datas){
			$arrKey = date('m-d-Y',strtotime($datas['note_date']));
			if(array_key_exists($arrKey,$calDatas)){
				$calDatas[$arrKey] .= '<a href="'. getSEO($datas['note_id'],$datas['title']) .'"'. (($datas['note_date']<date('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"') .' data-fancybox-type="iframe"><i class="'. $datas['note_icon'] .' cal_circle" style="background:'. $datas['note_color'] .'"></i> '. showIn($datas['title'],'page') .' <span class="eventTime pull-right"><i class="fa fa-clock-o"></i> '. date('H:i A',strtotime($datas['note_date'])) .'</span></a>';
			}else{
				$calDatas[$arrKey] = '<a href="'. getSEO($datas['note_id'],$datas['title']) .'"'. (($datas['note_date']<date('Y-m-d H:i') ) ? ' class="expDate fancybox"':' class="fancybox"') .' data-fancybox-type="iframe"><i class="'. $datas['note_icon'] .' cal_circle" style="background:'. $datas['note_color'] .'"></i> '. showIn($datas['title'],'page') .' <span class="eventTime pull-right"><i class="fa fa-clock-o"></i> '. date('H:i A',strtotime($datas['note_date'])) .'</span></a>';
			}
		}
		
		# Re-DESIGN
		$calTemp = array();
		$c = 0;
		foreach($calDatas as $k=>$v){
			$calTemp[] = '"'. $k .'" : \''. $v  .'\'';
			$c++;
		}
		
		$calendar.='<script>
		var codropsEvents = {
			'. implode(',',$calTemp) .'
		};
		</script>
		';
		
		# DRAW CALENDAR
		if($this->navigation){
		$calendar.='
						<div class="custom-calendar-wrap">
							<div id="custom-inner" class="custom-inner">
								<div class="custom-header clearfix">
									<nav>
										<span id="custom-prev" class="custom-prev"></span>
										<span id="custom-selDate" class="custom-selDate"></span>
										<span id="custom-next" class="custom-next"></span>
									</nav>
									<h2 id="custom-month" class="custom-month"></h2>
									<h3 id="custom-year" class="custom-year"></h3>
									<div id="jumpSelector">
										<div class="panel">
											<div class="panel-heading">'. calglb_date_selector .'</div>
											<div class="panel-body">
												<select id="jump-month" class="form-control autoWidth input-sm">';
												foreach($CAL_DATE_VALUES['months'] as $k=>$v){
													if($v!=''){
														$calendar.='<option value="'. $k .'">'. $v .'</option>';
													}
												}
												
		$calendar.='
												</select>
												<input type="number" id="jump-year" class="form-control autoWidth input-sm" value="'. $this->year .'">
												<button type="button" id="jumpDate" class="btn btn-warning btn-sm"><i class="fa fa-chevron-right"></i></button>
												
											</div>
										</div>
									</div>
								</div>
								<div id="calendar" class="fc-calendar-container"></div>
							</div>
						</div>
			';}
			
		unset($CAL_DATE_VALUES['months'][0]);
		unset($CAL_DATE_VALUES['monthabbrs'][0]);
		
		$addParams ='';
		foreach($addParam as $k=>$v){
			$addParams.='&'.$k.'='.$v;
		} $addParam = $addParams;
/* 		$addParam = '';
		
		if($this->widgetOn){
			$addParam = '&w=1';
			if($this->widgetUser!=0){
				$getUserKey = getUser($this->widgetUser,2);
				$addParam .= '&u='.$getUserKey;
			}
			if($this->widgetFetchData!=2){
				$addParam .= '&fd='.$this->widgetFetchData;
			}
		} */
		
		$calendar .='
<!-- Calendar Init -->
		<script type="text/javascript">
			$(function() {
				var transEndEventNames = {
						"WebkitTransition" : "webkitTransitionEnd",
						"MozTransition" : "transitionend",
						"OTransition" : "oTransitionEnd",
						"msTransition" : "MSTransitionEnd",
						"transition" : "transitionend"
					},
					transEndEventName = transEndEventNames[ Modernizr.prefixed( "transition" ) ],
					$wrapper = $( "#custom-inner" ),
					$calendar = $( "#calendar" ),
					cal = $calendar.calendario( {
						onDayClick : function( $el, $contentEl, dateProperties ) {';
							
		if($this->isAdmin==1){
		$calendar .='
						if( $contentEl.length == 0 ) {
							var linker = "'. cal_set_app_url .'sdr.calendar.php?pos=add&m="+ dateProperties[\'month\'] +"&d="+ dateProperties[\'day\'] +"&y="+dateProperties[\'year\'];
								$.fancybox({
									type:"iframe",
									href:linker,
									minHeight:500
								});
						}else{
							showEvents( $contentEl, dateProperties );
						}';
		}else{					
		$calendar .='
							
 							if( $contentEl.length > 0 ) {
								showEvents( $contentEl, dateProperties );
							}else{

							 }';
		}
		$calendar .='

						},
						caldata : codropsEvents,
						displayWeekAbbr : true,
						month:'. $this->month .',
						year:'. $this->year .',
						weeks : ['. "'" . implode("','", $CAL_DATE_VALUES['weeks']) . "'" .'],
						weekabbrs : ['. "'" . implode("','", $CAL_DATE_VALUES['weekabbrs']) . "'" .'],
						months : ['. "'" . implode("','", $CAL_DATE_VALUES['months']) . "'" .'],
						monthabbrs : ['. "'" . implode("','", $CAL_DATE_VALUES['monthabbrs']) . "'" .'],
					} ),
					$month = $( "#custom-month" ).html( cal.getMonthName() ),
					$year = $( "#custom-year" ).html( cal.getYear() );

				$( "#custom-next" ).on( "click", function() {
					cal.gotoNextMonth(loadDate);
				} );
				$( "#custom-prev" ).on( "click", function() {
					cal.gotoPreviousMonth(loadDate);
				} );

				
				/* Load Date */
				function loadDate(){
					var mm = cal.getMonth();
					var yy = cal.getYear();
					getAjax("#sdr-calendar","'. cal_set_app_url .'sdr.calendar.php?pos=cal'. $addParam .'&m="+ mm +"&y="+ yy +"",\'<i class="fa fa-cog fa-spin"></i>\');
				}
				
				function updateMonthYear() {				
					$month.html( cal.getMonthName() );
					$year.html( cal.getYear() );
				}

				// just an example..
				function showEvents( $contentEl, dateProperties ) {

					hideEvents();
					
					var $events = $( \'<div id="custom-content-reveal" class="custom-content-reveal mcsb"><h4>\' + dateProperties.monthname + \' \' + dateProperties.day + \', \' + dateProperties.year + \'</h4></div>\' ),
						$close = $( \'<span class="custom-content-close"></span>\' ).on( "click", hideEvents );';
						
				if($this->isAdmin==1){
					$calendar .='
						$add = $( \'<span class="custom-content-add"><i class="fa fa-plus"></i> '. calglb_add .'</span>\' ).on( "click", function(){
								$.fancybox({
									type:"iframe",
									href:"'. cal_set_app_url .'sdr.calendar.php?pos=add&m="+ dateProperties[\'month\'] +"&d="+ dateProperties[\'day\'] +"&y="+dateProperties[\'year\'],
									minHeight:500
								});
						} );';
				}else{
					$calendar .='$add="";';
				}
					
				$calendar .='
				
					$line = \'<div class="custom-content-line"></div>\';
					$events.append($contentEl.html(),$close,$add,$line).insertAfter( $wrapper );
				
					setTimeout( function() {
						$events.css( "top", "0%" );
						mcsb(".mcsb");
					}, 25 );

				}
				function hideEvents() {

					var $events = $( "#custom-content-reveal" );
					if( $events.length > 0 ) {
						
						$events.css( "top", "100%" );
						Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

					}

				}

				/* Jump Date */
				$("#custom-selDate").click(function(){
					$("#jumpSelector").slideToggle();
				});
				$("#jumpDate").click(function(){
					var mm = $("#jump-month option:selected").val();
					var yy = $("#jump-year").val();
					getAjax("#sdr-calendar","'. cal_set_app_url .'sdr.calendar.php?pos=cal'. $addParam .'&m="+ mm +"&y="+ yy +"",\'<i class="fa fa-cog fa-spin"></i>\');
				});

			});
		</script>
		';
		return $calendar;
		
	}
	
	public function getCalendar(){
		
		if($this->calDate!=null){
			$dateReq = $this->calDate;
			$this->day=date('d',strtotime($dateReq));
			$this->month=date('m',strtotime($dateReq));
			$this->year=date('Y',strtotime($dateReq));
		}
		
		if($this->day==null){$this->day = demoDate('d');}
		if($this->month==null){$this->month = demoDate('m');}
		if($this->year==null){$this->year = demoDate('Y');}
		$addParam = '';
		
		if($this->widgetOn){
			$addParam .= '&w=1';
			if($this->widgetUser!=0){
				$getUserKey = getUser($this->widgetUser,2); # ID to Key
				$addParam .= '&u='.$getUserKey;
			}else{
				$addParam .= '&u=-';
			}
			if($this->widgetFetchData!=2){
				$addParam .= '&fd='.$this->widgetFetchData;
			}else{
				$addParam .= '&fd=2';
			}
		}
		
		$getCal = '';
		$getCal .= '<script>
						$(document).ready(function(){
							getAjax("'. $this->element .'","'. cal_set_app_url .'sdr.calendar.php?pos=cal&m='. $this->month .'&d='. $this->day .'&y='. $this->year .$addParam.'",\'<i class="fa fa-cog fa-spin"></i>\');
						});
					</script>';
		return $getCal;
		
	}
	
	# Upcoming Events
	public function upcoming($showExp=true){
		
		global $db;
		$listData = array('error'=>0,'data'=>array());
		
		# Show Expiration 1 hour
		$expRange = (($showExp) ? date('Y-m-d H'):date('Y-m-d H:i'));
		
		# Demo Mode
		if(DEMO_MODE){
			$expRange = (($showExp) ? date('Y-m-d H',strtotime(DEMO_TODAY)):date('Y-m-d H:i',strtotime(DEMO_TODAY)));
		}
		
		# List Count
		$list_count = cal_set_max_upcoming;
		
		# Widget Settings
		if($this->widgetOn){
			if($this->widgetUser!=0){
				$db->where('user_id',$this->widgetUser);
			}
			if($this->widgetFetchData!=2){
				$db->where('data_type',$this->widgetFetchData);
			}
			$list_count = $this->widgetDataCount;
		}
		
		$getList = $db->where('note_date>=?',array($expRange))->orderBy('note_date','ASC')->get('panel_notes',array(0,$list_count));
		if($db->count==0){
			$listData['error'] = 1;
		}else{
			$listData['data'] = $getList;
		}
		
		return $listData;
		
	}
	
	# Todays Events
	public function todays($showExp=true){
		
		global $db;
		$listData = array('error'=>0,'data'=>array());
		
		$expRange = DateTime::createFromFormat("Y-m-d", date('Y-m-d'))->format("Ymd");
		if(DEMO_MODE){
			$expRange = DateTime::createFromFormat("Y-m-d H:i:s", DEMO_TODAY)->format("Ymd");
		}
		$listCount = 5;
				
		# Widget Settings
		if($this->widgetOn){
			if($this->widgetUser!=0){
				$db->where('user_id',$this->widgetUser);
			}
			if($this->widgetFetchData!=2){
				$db->where('data_type',$this->widgetFetchData);
			}
			$listCount = $this->widgetDataCount;
		}
		
		$getList = $db->where("DATE_FORMAT(note_date,'%Y%m%d') BETWEEN ? AND ?",array($expRange,$expRange))->orderBy('note_date','ASC')->get('panel_notes',array(0,$listCount));
		if($db->count==0){
			$listData['error'] = 1;
		}else{
			$listData['data'] = $getList;
		}
		
		return $listData;
		
	}
	
	# Navbar Events
	public function navbar($showExp=true){
		
		global $db,$CAL_SOUNDS;
		$listData = array('error'=>0,'data'=>array(),'count'=>0);
		
		$expRange = DateTime::createFromFormat("Y-m-d H", date('Y-m-d H'))->format("YmdH");
		if(DEMO_MODE){
			$expRange = DateTime::createFromFormat("Y-m-d H:i:s", DEMO_TODAY)->format("YmdH");
		}
		$listCount = 5;
				
		# Widget Settings
		if($this->widgetOn){
			if($this->widgetUser!=0){
				$db->where('user_id',$this->widgetUser);
			}
			if($this->widgetFetchData!=2){
				$db->where('data_type',$this->widgetFetchData);
			}
			$listCount = $this->widgetDataCount;
		}
		
		$getList = $db->where("DATE_FORMAT(note_date,'%Y%m%d%H') BETWEEN ? AND ?",array($expRange,$expRange))->orderBy('note_date','ASC')->get('panel_notes',array(0,$listCount));
		if($db->count==0){
			$listData['error'] = 1;
			$listData['count'] = 0;
		}else{
			$listData['data'] = $getList;
			$listData['count'] = 1;
		}
		
		return $listData;
		
	}

	# List Events
	public function listEvent($showExp=true){
		
		global $db;
		$listData = array('error'=>0,'data'=>array(),'pages'=>'');
		$listCount = 5;
		$pgGo = $this->widgetDataPg;
				
		# Widget Settings
		if($this->widgetOn){
			if($this->widgetUser!=0){
				$db->where('user_id',$this->widgetUser);
			}
			if($this->widgetFetchData!=2){
				$db->where('data_type',$this->widgetFetchData);
			}
			$listCount = $this->widgetDataCount;
		}
		$dtStart	 = ($pgGo-1)*$listCount;
		$getList = $db->withTotalCount()->orderBy('note_date','ASC')->get('panel_notes',array($dtStart,$listCount));
		$count = $db->totalCount;
		$total_page	 = ceil($count / $listCount);
		if($db->count==0){
			$listData['error'] = 1;
		}else{
			$listData['data'] = $getList;
		}
		$wk = $this->widgetKey;
		$listData['pages'] = $this->widgetPage($listCount,$count,"wk=$wk",$total_page,$pgGo);
		
		return $listData;
		
	}
	
	# Widget Pagination
	static public function widgetPage($limit,$count,$pgVar='',$total_page,$pgGo){
		
		$pagination = '
		<ul class="pagination pagination-sm no-margin'. ((isset($pgPos) && $pgPos==true) ? ' pull-right':'') .'">';
		if($limit > $count){$pagination .= '<li><a href="javascript:;">1</a></li>';}
		if($count > $limit) :
		 $x = 3; # Paging Page List
		 $lastP = ceil($count/$limit);

		 if($pgGo > 1){

		 $pgPrev = $pgGo-1;

		 $pagination .= '<li><a href="?'. $pgVar .'">«</a></li><li><a href="?'. $pgVar .'&amp;pgGo='. $pgPrev .'">&lt;</a></li>';

		 }

		 # Print page 1
		 if($pgGo==1) $pagination .= '<li class="active"><a href="javascript:;">1</a></li>';
		 else $pagination .= '<li><a href="?'. $pgVar .'">1</a></li>';
		 # Print "..." or only 2
		 if($pgGo-$x > 2) {
		 $pagination .= '<li class="disabled"><a href="javascript:;">...</a></li>';
		 $i = $pgGo-$x;
		 } else {
		 $i = 2;
		 }
		 # Print Pages
		 for($i; $i<=$pgGo+$x; $i++) {
		 if($i==$pgGo) $pagination .= '<li class="active"><a href="javascript:;">'. $i .'</a></li>';
		 else $pagination .= '<li><a href="?'. $pgVar .'&amp;pgGo='. $i .'">'. $i .'</a></li>';
		 if($i==$lastP) break;
		 }
		 # Print "..." or last page
		 if($pgGo+$x < $lastP-1) {
		 $pagination .= '<li class="disabled"><a href="javascript:;">...</a></li>';
		 $pagination .= '<li><a href="?'. $pgVar .'&amp;pgGo='. $lastP .'">'. $lastP .'</a></li>';
		 } elseif($pgGo+$x == $lastP-1) {
		 $pagination .= '<li><a href="?'. $pgVar .'&amp;pgGo='. $lastP .'">'. $lastP .'</a></li>';
		 }

		 if($pgGo < $lastP){

		 $pgNext = $pgGo+1;

		 $pagination .= '<li><a href="?'. $pgVar .'&amp;pgGo='. $pgNext .'">&gt;</a></li><li><a href="?'. $pgVar .'&amp;pgGo='. $total_page .'">»</a></li>';

		 }

		endif;
		
		return $pagination;
		
	}
	
	# Caledonian Mailer
	public function calMail(){
		
		
		require_once(CAL_APP.DIRECTORY_SEPARATOR.'component/phpMailer/init.engine.php');
		
		
		
	}
	
	# General Settings
	public function sysSettings(){
		
		$errText = '';
		
		if(!reqVal('cal_set_default_timezone','empty')){$errText .= '* Please choose a timezone<br>';}
		if(!reqVal('cal_set_default_language','empty')){$errText .= '* Please choose a default language<br>';}
		if(!reqVal('cal_set_app_url','empty')){$errText .= '* Invalid App Url<br>';}
		if(!reqVal('cal_set_sysmail','mail')){$errText .= '* Invalid System E-Mail<br>';}
		if(!reqVal('cal_set_max_upcoming','empty')){$errText .= '* Please enter a upcoming limit<br>';}
		if(!reqVal('cal_set_file_size','empty')){$errText .= '* Please choose a file size<br>';}
		if(!reqVal('cal_set_api_public','empty')){$errText .= '* Invalid public key<br>';}
		if(!reqVal('cal_set_api_private','empty')){$errText .= '* Invalid private key<br>';}
		if(!reqVal('cal_set_share_buttons','empty')){$cal_set_share_buttons=0;}else{$cal_set_share_buttons=1;}
		if(!reqVal('cal_set_pointips','empty')){$cal_set_pointips=0;}else{$cal_set_pointips=1;}
		if(!reqVal('cal_set_show_creator','empty')){$cal_set_show_creator=0;}else{$cal_set_show_creator=1;}
		if(!reqVal('cal_set_debug_mode','empty')){$cal_set_debug_mode=0;}else{$cal_set_debug_mode=1;}
		if(!reqVal('cal_set_seo_links','empty')){$cal_set_seo_links=0;}else{$cal_set_seo_links=1;}
		if(!reqVal('cal_set_license_key','empty')){$errText .= '* Please enter license key<br>';}else{
			if(!_iscurl()){
				$errText.='* cURL extension not active on your server!<br>';
			}else{
				$licenseVerify = curl_get_result('http://dev.artlantis.net/envato/verifier/license.verifier.php?it=caledonianPRO&key='.urlencode(trim($_POST['cal_set_license_key'])).'&url='.urlencode(trim($_SERVER['SERVER_NAME'])));
				if($licenseVerify != 'VALID_LICENSE'){
					$errText.='* Invalid License Key<br>';
				}
			}
		}
		
		if($errText==''){
			
			$confList = '';
			$confList.= "<?php\n";
			$confList .= "/*  +------------------------------------------------------------------------+ */
/*  | Artlantis CMS Solutions                                                | */
/*  +------------------------------------------------------------------------+ */
/*  | Caledonian PRO PHP Event Calendar                                      | */
/*  | Copyright (c) Artlantis Design Studio 2015. All rights reserved.       | */
/*  | Version       ". CAL_VERSION ."                                                      | */
/*  | Last modified ". date('d.m.Y') ."                                               | */
/*  | Email         developer@artlantis.net                                  | */
/*  | Web           http://www.artlantis.net                                 | */
/*  +------------------------------------------------------------------------+ */";
			$confList .= "\n\n";
			$confList .= "# General Settings\n";
			$confList .= "\$CAL_SETS['cal_set_default_timezone'] = '". mysql_prep($_POST['cal_set_default_timezone']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_default_language'] = '". mysql_prep($_POST['cal_set_default_language']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_app_url'] = '". mysql_prep($_POST['cal_set_app_url']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_sysmail'] = '". mysql_prep($_POST['cal_set_sysmail']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_max_upcoming'] = ". intval($_POST['cal_set_max_upcoming']) .";\n";
			$confList .= "\$CAL_SETS['cal_set_file_size'] = ". intval($_POST['cal_set_file_size']) .";\n";
			$confList .= "\$CAL_SETS['cal_set_api_public'] = '". mysql_prep($_POST['cal_set_api_public']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_api_private'] = '". mysql_prep($_POST['cal_set_api_private']) ."';\n";
			$confList .= "\$CAL_SETS['cal_set_share_buttons'] = ". $cal_set_share_buttons .";\n";
			$confList .= "\$CAL_SETS['cal_set_show_creator'] = ". $cal_set_show_creator .";\n";
			$confList .= "\$CAL_SETS['cal_set_pointips'] = ". $cal_set_pointips .";\n";
			$confList .= "\$CAL_SETS['cal_set_debug_mode'] = ". $cal_set_debug_mode .";\n";
			$confList .= "\$CAL_SETS['cal_set_seo_links'] = ". $cal_set_seo_links .";\n";
			$confList .= "\$CAL_SETS['cal_set_license_key'] = '". mysql_prep($_POST['cal_set_license_key']) ."';\n";
			$confList .= "\n\n";
			$confList .= "foreach(\$CAL_SETS as \$k=>\$v){if(!defined(\$k)){define(\$k,\$v);}}";
			$confList .= "\n";
			$confList .= "?>";
			
			$pathw = CAL_APP.DIRECTORY_SEPARATOR.'lib/cal.sets.php';
			if (!file_exists ($pathw) ) {
				@touch ($pathw);
			}
			
			$conc=@fopen ($pathw,'w');
			if (!$conc) {
				$this->errPrint = errMod('Setting File Cannot Be Open','danger');
				return false;
			}else{
				#************* Writing *****
				if (fputs ($conc,$confList) ){
					if(!$this->onInstall){
						header('Location: ?p=settings');
						return true;
						die();
					}else{
						return true;
					}
				}else {
					$this->errPrint = errMod('Settings Could Not Be Written!','danger');
				}
				fclose($conc);
				#************* Writing End **
			}
			
		}else{
			$this->errPrint = errMod($errText,'danger');
		}
		
	}
	
	# User List
	static public function userList($type='select',$selID=''){
		
		global $db;
		
		if($type=='select'){
			$data = '';
			$getList = $db->where('isActive=1')->orderBy('full_name','ASC')->get('users');
			foreach($getList as $getLists){
				$data.='<option value="'. $getLists['user_id'] .'"'. formSelector($getLists['user_id'],$selID,0) .'>'. showIn($getLists['full_name'],'page') .'</option>';
			}
			return $data;
		}
		
	}

	# Widget
	static public function Widget($ids='',$type='',$sets='[]'){
		
		$data = '';
		$wSets = json_decode($sets,true);
		$addPlug = '';
		
		# Selected Plugins
		if(in_array('jquery',$wSets['plugins'])){
			$addPlug=('<script src="'.cal_set_app_url.'valve/Scripts/jquery-1.11.3.min.js"></script>');}

		if(in_array('bootstrap',$wSets['plugins'])){
			$addPlug.=('<link rel="stylesheet" href="'.cal_set_app_url.'valve/bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="'.cal_set_app_url.'valve/bootstrap/css/flatly_bootstrap.min.css"><script src="'.cal_set_app_url.'valve/bootstrap/js/bootstrap.min.js"></script>');}

		if(in_array('datepicker',$wSets['plugins'])){
			$addPlug.=('<link href="'.cal_set_app_url.'valve/css/jquery-ui.min.css" rel="stylesheet"><link href="'.cal_set_app_url.'valve/css/jquery-ui.theme.min.css" rel="stylesheet"><script src="'.cal_set_app_url.'valve/Scripts/jquery-ui.min.js"></script><script src="'.cal_set_app_url.'valve/Scripts/dp_lang/'. DEFAULT_LANG .'.js"></script>');}
		
		$addPlug.=('<link href="'.cal_set_app_url.'valve/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" /><script src="'.cal_set_app_url.'valve/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>');
		
		###################################################
		
		# Full Calendar
		if($type=='full_calendar'){
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="width:700px; height: 550px; border:0;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		###################################################
		
		# Mini Calendar
		if($type=='mini_calendar'){
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="width:400px; height: 400px; border:0;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		###################################################
		
		# Upcoming Events
		if($type=='upcoming_list'){
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="width:100%; height:300px; border:0;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
			
			# Ajax
			$prepare = $addPlug.'<div id="widget_area"></div>';
			$prepare .= '<script> $(document).ready(function(){ $.ajax({ url : "'. cal_set_app_url .'widget.php?wk='. $ids .'", type: "GET", contentType: "application/x-www-form-urlencoded", success: function(data, textStatus, jqXHR) { $("#widget_area").html(data); }, error: function (jqXHR, textStatus, errorThrown) { $("#widget_area").html(\'Error Occured!\'); } }); }); </script>';
			$data .= '
				<div class="form-group">
					<label for="code2">Widget Code (Ajax)</label>
					<textarea rows="6" id="code2" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		
		###################################################
		
		# Todays Events
		if($type=='today_list'){
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="width:100%; height:300px; border:0;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
			
			# Ajax
			$prepare = $addPlug.'<div id="widget_area"></div>';
			$prepare .= '<script> $(document).ready(function(){ $.ajax({ url : "'. cal_set_app_url .'widget.php?wk='. $ids .'", type: "GET", contentType: "application/x-www-form-urlencoded", success: function(data, textStatus, jqXHR) { $("#widget_area").html(data); }, error: function (jqXHR, textStatus, errorThrown) { $("#widget_area").html(\'Error Occured!\'); } }); }); </script>';
			$data .= '
				<div class="form-group">
					<label for="code2">Widget Code (Ajax)</label>
					<textarea rows="6" id="code2" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		###################################################
		
		# Navbar Notices
		if($type=='navbar_notices'){			
			# Ajax
			if(array_key_exists('sound',$wSets) && $wSets['sound']==true){
				$addPlug.=('<script src="'.cal_set_app_url.'valve/widgets/scripts/buzz.min.js"></script>');
			}
			$prepare = $addPlug.'<div id="widget_area"></div>';
			$prepare .= '<script> $(document).ready(function(){ $.ajax({ url : "'. cal_set_app_url .'widget.php?wk='. $ids .'", type: "GET", contentType: "application/x-www-form-urlencoded", success: function(data, textStatus, jqXHR) { $(".caledonian").html(data); }, error: function (jqXHR, textStatus, errorThrown) { $(".caledonian").html(\'\'); } }); }); </script>';
			$data .= '
				<div class="form-group">
					<label for="code2">Widget Code (Ajax)</label>
					<textarea rows="6" id="code2" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		###################################################
		
		# Pop-up Master
		if($type=='popup_master'){			
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="display:none;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		###################################################
		
		# Event Lister
		if($type=='event_lister'){			
			# IFrame
			$prepare = '<iframe id="'. $ids .'" style="width:100%; height: 550px; border:0;" frameborder="0" src="'. cal_set_app_url .'widget.php?wk='. $ids .'"></iframe>';
			$data = '
				<div class="form-group">
					<label for="code1">Widget Code (Iframe)</label>
					<textarea rows="6" id="code1" class="form-control" onclick="this.select();" readonly>'. $prepare .'</textarea>
				</div>
			';
		}
		
		# Done
		return $data;
	}
	
	# Widget Fields
	public function WidgetFields(){
		
		$formData = '';
		$edWidSet = array();
		global $CAL_SOUNDS;
		
		$expWidSet = $this->widgetEditData;
		if(array_key_exists('widget_settings',$expWidSet)){
			$edWidSet = json_decode($expWidSet['widget_settings'],true);
		}
		
		# Full Calendar
		if($this->widgetType=='full_calendar'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';

			}
		}
		
		# Mini Calendar
		if($this->widgetType=='mini_calendar'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';
			}
		}
		
		# Upcoming Events
		if($this->widgetType=='upcoming_list'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth" value="'. showIn($expWidSet['max_data'],'input') .'">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';
			}
		}
		
		# Navbar Notices
		if($this->widgetType=='navbar_notices'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<label for="refresh_time">'. calglb_refresh_time .' ('. calglb_seconds .')</label>
						<input type="number" name="refresh_time" id="refresh_time" value="15" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<label for="event_sound">'. calglb_sound .'</label>
						<input type="checkbox" name="event_sound" id="event_sound" value="YES" class="iCheck">
					</div>
					<div id="soundList" class="sHide">
					<div class="form-group">
						<label for="event_sound_file">'. calglb_sound_file .'</label>
						<select name="event_sound_file" id="event_sound_file" class="form-control autoWidth" style="display:inline-block">';
							foreach($CAL_SOUNDS as $k=>$v){
								$formData.='<option value="'. $k .'">'. $v['name'] .'</option>';
							}
				$formData.='
						</select> <button type="button" name="testSound" id="testSound" class="btn btn-warning btn-sm"><i class="fa fa-play"></i></button>
						<script>
							$(document).ready(function(){
								$("#testSound").click(function(){
									var selAudio = $("#event_sound_file option:selected").val();
									var soundFile = "/valve/widgets/sounds/"+ selAudio +".mp3";
									var mySound = new buzz.sound( soundFile, {
										//formats: ["mp3"]
									});
									mySound.play();
								});
								
								// Sound Toggle
								$("#event_sound").on("ifToggled",function(){
									$("#soundList").slideToggle();
								});
								
							});
						</script>
					</div>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="'. $expWidSet['max_data'] .'" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<label for="refresh_time">'. calglb_refresh_time .' ('. calglb_seconds .')</label>
						<input type="number" name="refresh_time" id="refresh_time" value="'. $edWidSet['refreshTime'] .'" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<label for="event_sound">'. calglb_sound .'</label>
						<input type="checkbox" name="event_sound" id="event_sound" value="YES" class="iCheck"'. formSelector($edWidSet['sound'],true,1) .'>
					</div>
					<div id="soundList"'. (($edWidSet['sound']==true) ? '':' class="sHide"') .'>
					<div class="form-group">
						<label for="event_sound_file">'. calglb_sound_file .'</label>
						<select name="event_sound_file" id="event_sound_file" class="form-control autoWidth" style="display:inline-block">';
							foreach($CAL_SOUNDS as $k=>$v){
								$formData.='<option value="'. $k .'"'. formSelector(basename($edWidSet['soundFile'],'.mp3'),$k,0) .'>'. $v['name'] .'</option>';
							}
				$formData.='
						</select> <button type="button" name="testSound" id="testSound" class="btn btn-warning btn-sm"><i class="fa fa-play"></i></button>
						<script>
							$(document).ready(function(){
								$("#testSound").click(function(){
									var selAudio = $("#event_sound_file option:selected").val();
									var soundFile = "/valve/widgets/sounds/"+ selAudio +".mp3";
									var mySound = new buzz.sound( soundFile, {
										//formats: ["mp3"]
									});
									mySound.play();
								});
								
								// Sound Toggle
								$("#event_sound").on("ifToggled",function(){
									$("#soundList").slideToggle();
								});
								
							});
						</script>
					</div>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';
			}
		}
		
		# Todays Events
		if($this->widgetType=='today_list'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="'. showIn($expWidSet['max_data'],'input') .'" class="form-control autoWidth">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';
			}
		}
		
		# Popup Master
		if($this->widgetType=='popup_master'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="start_date">'. calglb_start .'</label>
								<input type="text" name="start_date" id="start_date" value="" class="form-control datepicker" placeholder="dd/mm/yyyy">
							</div>
							<div class="col-md-6">
								<label for="end_date">'. calglb_end .'</label>
								<input type="text" name="end_date" id="end_date" value="" class="form-control datepicker" placeholder="dd/mm/yyyy">
							</div>
						</div>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
					<script>
						$(".datepicker").datepicker({
							dateFormat:"dd/mm/yy",
							changeMonth: true,
							numberOfMonths: 3
						});
					</script>
				';
			}else{
				
				# Controls
				if(!array_key_exists('time_range',$edWidSet)){
					$edWidSet['time_range']['start'] = date('Y-m-d');
					$edWidSet['time_range']['end'] = date('Y-m-d');
				}else{
					if(!array_key_exists('start',$edWidSet['time_range'])){$edWidSet['time_range']['start'] = date('Y-m-d');}
					if(!array_key_exists('end',$edWidSet['time_range'])){$edWidSet['time_range']['end'] = date('Y-m-d');}
				}
				
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_maximum_event .'</label>
						<input type="number" name="list_count" id="list_count" value="'. showIn($expWidSet['max_data'],'input') .'" class="form-control autoWidth">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="start_date">'. calglb_start .'</label>
								<input type="text" name="start_date" id="start_date" value="'. showIn(date('d/m/Y',strtotime($edWidSet['time_range']['start'])),'input') .'" class="form-control datepicker" placeholder="dd/mm/yyyy">
							</div>
							<div class="col-md-6">
								<label for="end_date">'. calglb_end .'</label>
								<input type="text" name="end_date" id="end_date" value="'. showIn(date('d/m/Y',strtotime($edWidSet['time_range']['end'])),'input') .'" class="form-control datepicker" placeholder="dd/mm/yyyy">
							</div>
						</div>
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
					<script>
						$(".datepicker").datepicker({
							dateFormat:"dd/mm/yy",
							changeMonth: true,
							numberOfMonths: 3
						});
					</script>
				';
			}
		}
		
		# Event Lister
		if($this->widgetType=='event_lister'){
			
			if(!$this->widgetEdit){
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($_POST['widUser'])) ? $_POST['widUser']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0">'. calglb_private .'</option>
							<option value="1">'. calglb_public .'</option>
							<option value="2">'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_page_count .'</label>
						<input type="number" name="list_count" id="list_count" value="5" class="form-control autoWidth">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery">
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap">
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker">
					</div>
				';
			}else{
				$formData.='
					<div class="form-group">
						<label for="widUser">'. calglb_user .'</label>
						<select name="widUser" id="widUser" class="form-control autoWidth">
							<option value="0">'. calglb_all_users .'</option>
							'. $this->userList('select',((isset($expWidSet['data_user'])) ? $expWidSet['data_user']:'')) .'
						</select>
					</div>
					<div class="form-group">
						<label for="widData">'. calglb_data_type .'</label>
						<select name="widData" id="widData" class="form-control autoWidth">
							<option value="0"'. formSelector($expWidSet['widget_data'],0,0) .'>'. calglb_private .'</option>
							<option value="1"'. formSelector($expWidSet['widget_data'],1,0) .'>'. calglb_public .'</option>
							<option value="2"'. formSelector($expWidSet['widget_data'],2,0) .'>'. calglb_all .'</option>
						</select>
					</div>
					<div class="form-group">
						<label for="list_count">'. calglb_page_count .'</label>
						<input type="number" name="list_count" id="list_count" value="'. showIn($expWidSet['max_data'],'input') .'" class="form-control autoWidth">
					</div>
					<div class="form-group well">
						<h5>'. calglb_plugins .'</h5>
						<label for="widScript1">Jquery</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript1" value="jquery"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('jquery',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript2">Bootstrap</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript2" value="bootstrap"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('bootstrap',$edWidSet['plugins'])) ? ' checked':''):'') .'>
						<label for="widScript3">Datepicker</label>
						<input type="checkbox" class="iCheck" name="widScript[]" id="widScript3" value="datepicker"'. ((array_key_exists('plugins',$edWidSet)) ? ((in_array('datepicker',$edWidSet['plugins'])) ? ' checked':''):'') .'>
					</div>
				';
			}
			
		}
		
		# XML Event
		
		return $formData;
		
	}
}

/* Session Master */
class sessionMaster{

	public $sesType = 0; # 0 - Classic Cookie
	public $sesName = null;
	public $sesVal = '';
	public $sesTime = 0;
	public $sesPath = '/';
	public $sesDomain = null;
	public $sesSecure = false;
	public $sesHttp = true;
	public $sesList = '';
	
	public function sessMaster(){
	
		setcookie($this->sesName, 
				  $this->sesVal, 
				  $this->sesTime,
				  $this->sesPath,
				  $this->sesDomain,
				  $this->sesSecure,
				  $this->sesHttp
				 );
	
	}
	
	public function sessDestroy(){
	
		$cookieList = explode(',',$this->sesList);
		
		foreach($cookieList as $k=>$v){
		
			setcookie($v, 
					  '', 
					  time()-3600,
					  $this->sesPath,
					  $this->sesDomain,
					  $this->sesSecure,
					  $this->sesHttp
					 );
		}
	
	}

}
?>