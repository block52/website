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
?>
<!-- DASHBOARD START -->
			<div class="row">
				<div class="col-md-3">
					<h3><?php echo(calglb_upcoming_events);?></h3><hr>
					<?php $upcList = new caledonian();
					$upcList = $upcList->upcoming(true); # Show 1 hour expiration, default true
					if($upcList['error']){echo(errMod(calglb_record_not_found,'danger'));}else{
					# List Upcoming Events
					?>
						<ul class="timeline">
							<?php foreach($upcList['data'] as $list){?>
							<li>
								<i class="<?php echo($list['note_icon']);?>" style="background:<?php echo($list['note_color']);?>"></i>
								<div class="timeline-item">
									<h3 class="timeline-header">
										<a href="javascript:;" data-fancybox-href="<?php echo(getSEO($list['note_id'],$list['title']));?>" data-fancybox-type="iframe" <?php echo(((date('Y-m-d H:i',strtotime($list['note_date'])) < demoDate('Y-m-d H:i')) ? ' class="expDate fancybox"':' class="fancybox"'));?>><?php echo(showIn($list['title'],'page'));?></a>
										<span class="time-label"><i class="fa fa-clock-o"></i> <?php echo(date('d/m/Y H:i A',strtotime($list['note_date'])));?></span>
									</h3>
								</div>
							</li>
							<?php }?>
						</ul>
					<?php }?>
				</div>
				<div class="col-md-9">
					<div id="sdr-calendar" style="min-height:500px;"></div>
					<?php 
					$cal = new caledonian(); 
					if(DEMO_MODE){$cal->calDate = date('Y-m-d H:i:s',strtotime(DEMO_TODAY));}
					echo($cal->getCalendar());?>
				</div>
			</div>
<!-- DASHBOARD END -->