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
# AJAX check
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	die('You have no access to view this page!');
}
require_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'caledonian.php');
$month = ((!isset($_GET['m']) || empty($_GET['m'])) ? date('n'):$_GET['m']);
$year = ((!isset($_GET['y']) || empty($_GET['y'])) ? date('Y'):$_GET['y']);
$selDate = $year.'-'.$month.'-'.'01 00:00:00';

$calendar = '';

# PREPARE TASKS
$calDatas = array();
$data = $db
			->where("(user_id=? OR user_id=?) AND DATE_FORMAT(note_date,'%Y-%m')=?",array(SDR_AUTH_ID,0,date('Y-m',strtotime($selDate))))
			->get('panel_notes');
foreach($data as $datas){
	$calDatas[] = '"'. date('m-d-Y',strtotime($datas['note_date'])) .'" : \'<a href="">'. showIn($datas['title'],'page') .'</a>\'';
}
$calendar.='<script>
var codropsEvents = {
	'. implode(',',$calDatas) .'
};</script>
';

# DRAW CALENDAR
$calendar.='
				<div class="custom-calendar-wrap">
					<div id="custom-inner" class="custom-inner">
						<div class="custom-header clearfix">
							<nav>
								<span id="custom-prev" class="custom-prev"></span>
								<span id="custom-next" class="custom-next"></span>
							</nav>
							<h2 id="custom-month" class="custom-month"></h2>
							<h3 id="custom-year" class="custom-year"></h3>
						</div>
						<div id="calendar" class="fc-calendar-container"></div>
					</div>
				</div>
';
echo($calendar);
unset($SDR_DATE_VALUES['months'][0]);
unset($SDR_DATE_VALUES['monthabbrs'][0]);
?>
<!-- Calendar Init -->
		<script type="text/javascript">
			$(function() {							
				var transEndEventNames = {
						'WebkitTransition' : 'webkitTransitionEnd',
						'MozTransition' : 'transitionend',
						'OTransition' : 'oTransitionEnd',
						'msTransition' : 'MSTransitionEnd',
						'transition' : 'transitionend'
					},
					transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
					$wrapper = $( '#custom-inner' ),
					$calendar = $( '#calendar' ),
					cal = $calendar.calendario( {
						onDayClick : function( $el, $contentEl, dateProperties ) {
							
							var linker = 'manage/sdr.calendarPop.php?m='+ dateProperties['month'] +'&d='+ dateProperties['day'] +'&y='+dateProperties['year'];
								$.fancybox({
									type:'iframe',
									href:linker,
									minHeight:500
								});
							
/* 							if( $contentEl.length > 0 ) {
								showEvents( $contentEl, dateProperties );
							}else{

							 } */

						},
						caldata : codropsEvents,
						displayWeekAbbr : true,
						month:<?php echo($month);?>,
						year:<?php echo($year);?>,
						weeks : [<?php echo("'" . implode("','", $SDR_DATE_VALUES['weeks']) . "'");?>],
						weekabbrs : [<?php echo("'" . implode("','", $SDR_DATE_VALUES['weekabbrs']) . "'");?>],
						months : [<?php echo("'" . implode("','", $SDR_DATE_VALUES['months']) . "'");?>],
						monthabbrs : [<?php echo("'" . implode("','", $SDR_DATE_VALUES['monthabbrs']) . "'");?>],
					} ),
					$month = $( '#custom-month' ).html( cal.getMonthName() ),
					$year = $( '#custom-year' ).html( cal.getYear() );

				$( '#custom-next' ).on( 'click', function() {
					cal.gotoNextMonth(loadDate);
				} );
				$( '#custom-prev' ).on( 'click', function() {
					cal.gotoPreviousMonth(loadDate);
				} );

				
				/* Load Date */
				function loadDate(){
					var mm = cal.getMonth();
					var yy = cal.getYear();
					getAjax('#sdr-calendar','manage/sdr.calendar.php?m='+ mm +'&y='+ yy +'','');
				}
				
				function updateMonthYear() {				
					$month.html( cal.getMonthName() );
					$year.html( cal.getYear() );
				}

				// just an example..
				function showEvents( $contentEl, dateProperties ) {

					hideEvents();
					
					var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Events for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>' ),
						$close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

					$events.append( $contentEl.html() , $close ).insertAfter( $wrapper );
					
					setTimeout( function() {
						$events.css( 'top', '0%' );
					}, 25 );

				}
				function hideEvents() {

					var $events = $( '#custom-content-reveal' );
					if( $events.length > 0 ) {
						
						$events.css( 'top', '100%' );
						Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

					}

				}
			
			});
		</script>