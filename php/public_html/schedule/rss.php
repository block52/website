<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 31.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
include_once('caledonian.php');

		header ("Content-type: text/xml");
		$rss_title = 'Caledonian RSS';
		$rssfeed = '<?xml version="1.0" encoding="UTF-8"?>';
		$rssfeed .= '<rss version="2.0">';
		$rssfeed .= '<channel>';
		$rssfeed .= '<title>'. rss_filter($rss_title) .'</title>';
		$rssfeed .= '<link>'. lethe_root_url .'</link>';
		$rssfeed .= '<description>'. rss_filter($rss_title . ' RSS feed') .'</description>';
		$rssfeed .= '<language>en_EN</language>';
		$rssfeed .= '<copyright>Copyright (C) '. date("Y") .' artlantis.net</copyright>';
		
		# Load Events
		# Only Public Events
		$opCamp = $db->where("data_type=?",array(0))->orderBy('note_date','ASC')->get('panel_notes');
										
		foreach($opCamp as $opCampRs){
			$rssfeed .= '<item>';
			$rssfeed .= '<title>' . rss_filter($opCampRs['title']) . '</title>';
			$rssfeed .= '<link>'. getSEO($opCampRs['note_id'],$opCampRs['title']) .'/</link>';
			$rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($opCampRs['add_date'])) . '</pubDate>';
			$rssfeed .= '</item>';
		}
		
		$rssfeed .= '</channel>';
		$rssfeed .= '</rss>';
		$rssfeed = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $rssfeed);
		echo($rssfeed);
		$myconn->close();
?>