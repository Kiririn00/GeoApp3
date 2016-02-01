<?php
//this is controller

class LocationController extends AppController{
	//set layout for all action in this controller
	//var $layout = 'masterLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text' );
	//set object model
	var $uses = array('Location');
	
	
	public function index(){
		$this->Model->setDataSource('seichichan');
		$this->redirect(array('action' => 'SaveLocation'));
	}
	
	public function CurrentLocation(){
	
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		if($this->request->is('post'))
		{
			$Latitude = $_POST['latitude'];
			$Longitude = $_POST['longitude'];
			$UserId = $this->Session->read('UserId');
			$Memo = $_POST['memo'];
			$LocationName = $_POST['location_name'];
			
			$this->Location->create();
			$this->Location->save(array(
				'user_id' => $UserId,	
				'location_name' => $LocationName,
				'location_memo' => $Memo,
				'latitude' => $Latitude,
				'longitude' => $Longitude,
				'checkin_date' => date('Y-m-d G:i:s')				
			));
			
			$this->Session->setFlash('<script>マップが保存しました</script>');
			
			$this->redirect(array(
					'controller' => 'Article',
					'action' => 'Home'
			));
		}//end if check post
			
	}

	public function SearchLocation(){
	
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		
		if($this->request->is('post'))
		{
			$Latitude =$_POST['latitude'];
			$Longitude =$_POST['longitude'];
			$UserId = $this->Session->read('UserId');
			
			$Memo = $_POST['memo'];
			$LocationName = $_POST['location_name'];
			
			$this->Location->create();
			$this->Location->save(array(
				'user_id' => $UserId,
				'location_name' => $LocationName,
				'location_memo' => $Memo,
				'latitude' => $Latitude,
				'longitude' => $Longitude,
				'checkin_date' => date('Y-m-d G:i:s')				
			));
			
			$this->Session->setFlash('<script>マップが保存しました</script>');
			
			$this->redirect(array(
					'controller' => 'Article',
					'action' => 'Home'
			));
		}

	}
}//end class


?>