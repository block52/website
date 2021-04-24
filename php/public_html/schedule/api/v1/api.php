<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 14.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
require_once 'API.class.php';
require_once '../../caledonian.php';
if(DEMO_MODE){die('Demo Mode Active!');}
class CalAPI extends API
{
	protected $User;
	
    public function __construct($request, $origin) {
        parent::__construct($request);
		
		$APIKey = new APIKey();
		$User = new User();
		$retError = array('RESULT'=>'');
		
        if (!array_key_exists('apiKey', $this->request)) {
			$retError['RESULT'] = 'NO_API_KEY_PROVIDED'; return $retError;
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            $retError['RESULT'] = 'INVALID_API_KEY'; return $retError;
        } else if (array_key_exists('token', $this->request) &&
             !$User->get('token', $this->request['token'])) {

            $retError['RESULT'] = 'INVALID_USER_TOKEN'; return $retError;
        }

        $this->User = $User->get('token', $this->request['token']);

    }

    /**
     * ADD Endpoint
     */
     protected function add() {
		 
		 $retError = array('RESULT'=>'');
		 global $db;
		 $userid = '-';
		 
        if ($this->method == 'POST') {
			
			# API Check
			$APIKey = new APIKey();
			if (!array_key_exists('apiKey', $this->request)) {
				$retError['RESULT'] = 'NO_API_KEY_PROVIDED'; return $retError;
			} else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
				$retError['RESULT'] = 'INVALID_API_KEY'; return $retError;
			}
			
            if(!isset($_POST['title']) || empty($_POST['title'])){$retError['RESULT'] = 'INVALID_TITLE'; return $retError;}
			if(!isset($_POST['event']) || empty($_POST['event'])){$retError['RESULT'] = 'INVALID_DETAILS'; return $retError;}
			if(!isset($_POST['event_date']) || empty($_POST['event_date'])){$retError['RESULT'] = 'INVALID_DATE'; return $retError;}
			if(!isset($_POST['user']) || empty($_POST['user'])){
				# Make for primary user
				$User = new User();
				$userid = $User->get('token', '-');
			}else{
				$User = new User();
				$userid = $User->get('token', $_POST['user']);
			}
			
			$data = array();
			$data['user_id'] = $userid->user_id;
			$data['title'] = $_POST['title'];
			$data['mynotes'] = $_POST['event'];
			$data['note_date'] = $_POST['event_date'];
			$data['add_date'] = date('Y-m-d H:i:s');
			$data['note_icon'] = ((!isset($_POST['icon']) || empty($_POST['icon'])) ? 'fa fa-bell':$_POST['icon']);
			$data['note_color'] = ((!isset($_POST['color']) || empty($_POST['color'])) ? 'mediumvioletred':$_POST['color']);
			$data['ip_address'] = ((!isset($_POST['ip']) || empty($_POST['ip'])) ? $_SERVER['REMOTE_ADDR']:$_POST['ip']);
			$data['edit_date'] = date('Y-m-d H:i:s');
			
			if($db->insert('panel_notes',$data)){
				$retError['RESULT'] = 'EVENT_CREATED'; return $retError;
			}else{
				$retError['RESULT'] = 'EVENT_NOT_CREATED'; return $retError;
			}
			
        } else {
            $retError['RESULT'] = 'ONLY_POST_REQUESTS'; return $retError;
        }
     }
	 
    /**
     * GET Endpoint
     */
     protected function lists() {
		 		 
		 $retError = array('RESULT'=>'');
		 $oneday = '-';
		 $userid = '-';
		 global $db;
		 
        if ($this->method == 'POST') {
			
			# API Check
			$APIKey = new APIKey();
			if (!array_key_exists('apiKey', $this->request)) {
				$retError['RESULT'] = 'NO_API_KEY_PROVIDED'; return $retError;
			} else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
				$retError['RESULT'] = 'INVALID_API_KEY'; return $retError;
			}
		
	
            if(!isset($_POST['from']) || empty($_POST['from'])){$_POST['from'] = date('Ymd');}else{$_POST['from']=date('Ymd',strtotime($_POST['from']));}
			if(!isset($_POST['to']) || empty($_POST['to'])){$_POST['to'] = date('Ymd');}else{$_POST['to']=date('Ymd',strtotime($_POST['to']));}
			if(!isset($_POST['oneday']) || $_POST['oneday']==''){$oneday='-';}{$oneday=date('Ymd',strtotime($_POST['oneday']));}
			if(!isset($_POST['offset']) || empty($_POST['offset'])){$_POST['offset'] = 0;}
			if(!isset($_POST['count']) || empty($_POST['count'])){$_POST['count'] = 15;}
			if(!isset($_POST['user']) || empty($_POST['user'])){$userid = '-';}else{
				$User = new User();
				$userid = $User->get('token', $_POST['user']);
			}
			
			# User Specific
			if($userid!='-'){
				$db->where('user_id=?',array($userid->user_id));
			}
			
			# Get One Day
			if($oneday!='19700101'){
				
				$db->where("DATE_FORMAT(note_date,'%Y%m%d') = ?",array($oneday));
				
			}else{
			# With Date Range
				$db->where("DATE_FORMAT(note_date,'%Y%m%d') BETWEEN ? AND ?",array($_POST['from'],$_POST['to']));
			}
			
			$data = $db->withTotalCount()->get('panel_notes',array($_POST['offset'],$_POST['count']));
						
			if($db->count==0){
				$retError['RESULT'] = 'NO_RECORD'; return $retError;
			}else{
				$retError['RESULT'] = $data; return $retError;
			}
			
        } else {
            $retError['RESULT'] = 'ONLY_POST_REQUESTS'; return $retError;
        }
     }
	 
    /**
     * DELETE Endpoint
     */
     protected function delete() {
		 		 
		 $retError = array('RESULT'=>'');
		 $oneday = '-';
		 $userid = '-';
		 $id=0;
		 global $db;
		 
        if ($this->method == 'POST') {
			
			# API Check
			$APIKey = new APIKey();
			if (!array_key_exists('apiKey', $this->request)) {
				$retError['RESULT'] = 'NO_API_KEY_PROVIDED'; return $retError;
			} else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
				$retError['RESULT'] = 'INVALID_API_KEY'; return $retError;
			}
		
	
            if(!isset($_POST['id']) || empty($_POST['id'])){$id=0;}else{$id=$_POST['id'];}
			if(!isset($_POST['user']) || empty($_POST['user'])){$userid = '-';}else{
				$User = new User();
				$userid = $User->get('token', $_POST['user']);
			}
			
			# User Specific
			if($userid!='-'){
				$db->where('user_id=?',array($userid->user_id));
			}
			
			$db->where('note_id=?',array($id));
								
			if(!$db->delete('panel_notes')){
				$retError['RESULT'] = 'NO_RECORD'; return $retError;
			}else{
				$retError['RESULT'] = 'REMOVED'; return $retError;
			}
			
        } else {
            $retError['RESULT'] = 'ONLY_POST_REQUESTS'; return $retError;
        }
     }
	 
 }
 
 
# Verification
class APIKey{
	
	public function verifyKey($key, $origin){
		
		if($key!=cal_set_api_private){
			return false;
		}else{
			return true;
		}
		
	}
	
}

# Load User
class User{
	
	public function get($r,$data){
		
		global $db;
		
		if($r=='token'){
			
			$userData = $db->where('public_key=?',array($data))->getOne('users');
			
			if($db->count==0){
				$userData = $db->where('isPrimary',1)->getOne('users');
				return (object)$userData;
				
			}else{
				return (object)$userData;
			}
			
		}
		
	}
	
}

 // Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new CalAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
?>