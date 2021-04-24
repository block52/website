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
# Date Values
$CAL_DATE_VALUES = array(
							'weeks'=>array(calglb_sunday, calglb_monday, calglb_tuesday, calglb_wednesday, calglb_thursday, calglb_friday, calglb_saturday),
							'weekabbrs'=>array(calglb_sunday_min, calglb_monday_min, calglb_tuesday_min, calglb_wednesday_min, calglb_thursday_min, calglb_friday_min, calglb_saturday_min),
							'months'=>array('',calglb_january, calglb_february, calglb_march, calglb_april, calglb_may, calglb_june, calglb_july, calglb_august, calglb_september, calglb_october, calglb_november, calglb_december),
							'monthabbrs'=>array('','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
						);
						
# Event Features
$CAL_EVENT_ICONS = array('fa-whatsapp','fa-area-chart','fa-bank','fa-bell','fa-birthday-cake','fa-book','fa-bullhorn','fa-bus','fa-calculator','fa-calendar','fa-camera','fa-check','fa-cloud','fa-coffee','fa-comments','fa-credit-card','fa-cutlery','fa-envelope','fa-fax','fa-futbol-o','fa-group','fa-heart','fa-phone','fa-reply-all','fa-remove','fa-star','fa-thumbs-up','fa-thumbs-down','fa-trash','fa-truck','fa-trophy','fa-paypal');
$CAL_EVENT_COLORS = array('deeppink','hotpink','lightpink','mediumvioletred','palevioletred','pink','crimson','darkred','darksalmon','firebrick','indianred','lightcoral','lightsalmon','red','salmon','coral','darkorange','gold','orange','orangered','tomato','darkkhaki','khaki','lemonchiffon','lightgoldenrodyellow','lightyellow','moccasin','palegoldenrod','papayawhip','peachpuff','yellow','bisque','blanchedalmond','brown','burlywood','chocolate','cornsilk','darkgoldenrod','goldenrod','maroon','peru','rosybrown','saddlebrown','sandybrown','sienna','tan','wheat','chartreuse','darkgreen','darkolivegreen','darkseagreen','forestgreen','green','greenyellow','lawngreen','lightgreen','lime','limegreen','mediumseagreen','mediumspringgreen','olive','olivedrab','palegreen','seagreen','springgreen','yellowgreen','cadetblue','cyan','darkcyan','lightcyan','teal','blue','blueviolet','cornflowerblue','darkblue','deepskyblue','dodgerblue','lightblue','lightskyblue','lightsteelblue','mediumblue','midnightblue','navy','powderblue','royalblue','skyblue','steelblue','darkmagenta','darkorchid','darkslateblue','darkviolet','fuchsia','indigo','lavender','magenta','mediumorchid','mediumpurple','mediumslateblue','orchid','plum','purple','slateblue','thistle','violet','aliceblue','antiquewhite','azure','beige','black','darkgray','darkslategray','dimgrey','floralwhite','gainsboro','ghostwhite','grey','honeydew','ivory','lavenderblush','lightgrey','lightslategrey','linen','mintcream','mistyrose','navajowhite','oldlace','seashell','silver','slategray','snow','white','whitesmoke');

# File Sizes
$CAL_FILE_SIZES = array(
						'512000'=>'500 KB',
						'1048576'=>'1 MB',
						'2097152'=>'2 MB',
						'5242880'=>'5 MB',
						'10485760'=>'10 MB',
						'26214400'=>'25 MB'
						);
						
# Widgets
$CAL_WIDGETS = array(
						'full_calendar'=>array(
												'name'=>'Full Calendar',
												'info'=>'Full Public Calendar',
												'preview'=>cal_set_app_url.'valve/widgets/images/full_calendar.png'
											   ),
						'mini_calendar'=>array(
												'name'=>'Mini Calendar',
												'info'=>'Mini Public Calendar',
												'preview'=>cal_set_app_url.'valve/widgets/images/mini_calendar.png'
											   ),
						'upcoming_list'=>array(
												'name'=>'Upcoming Event List',
												'info'=>'Upcoming Event Lister',
												'preview'=>cal_set_app_url.'valve/widgets/images/upcoming_event.png'
											   ),
						'today_list'=>array(
												'name'=>'Today\'s Event',
												'info'=>'Today\'s Event Lister',
												'preview'=>cal_set_app_url.'valve/widgets/images/today_event.png'
											   ),
						'navbar_notices'=>array(
												'name'=>'Navbar Notices',
												'info'=>'Bootstrap or Back-end page notifications',
												'preview'=>cal_set_app_url.'valve/widgets/images/navbar_notices.png'
											   ),
						'popup_master'=>array(
												'name'=>'Pop-up Master',
												'info'=>'Pop-up / Modal opener for front-end pages',
												'preview'=>cal_set_app_url.'valve/widgets/images/popup_master.png'
											   ),
						'event_lister'=>array(
												'name'=>'Event Lister',
												'info'=>'Full Event Lists',
												'preview'=>cal_set_app_url.'valve/widgets/images/event_lister.png'
											   )
					);
					
# Sound Files
$CAL_SOUNDS = array(
						'sound001'=>array(
									'name'=>'Sound 1',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound001.mp3'),
						'sound002'=>array(
									'name'=>'Sound 2',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound002.mp3'),
						'sound003'=>array(
									'name'=>'Sound 3',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound003.mp3'),
						'sound004'=>array(
									'name'=>'Sound 4',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound004.mp3'),
						'sound005'=>array(
									'name'=>'Sound 5',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound005.mp3'),
						'sound006'=>array(
									'name'=>'Sound 6',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound006.mp3'),
						'sound007'=>array(
									'name'=>'Sound 7',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound007.mp3'),
						'sound008'=>array(
									'name'=>'Sound 8',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound008.mp3'),
						'sound009'=>array(
									'name'=>'Sound 9',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound009.mp3'),
						'sound010'=>array(
									'name'=>'Sound 10',
									'file'=>cal_set_app_url.'valve/widgets/sounds/sound010.mp3'),
					);
					
?>