<?php
//this is controller
class UserController extends AppController{
	//set layout for all action in this controller
	//var $layout = 'masterLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text','Session' );
	//set object model
	var $uses = array('User','Comment','Article');
	
//action

	public function index(){
		
	}
	
	public function Register(){
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		//not get post data case
		if(!$this->request->is('post')){
			
			$this->render('register');
		}
		
		//get post data case
		else if($this->request->is('post')){
				
			//ok in confirm
			if(isset($_POST['ok']))
			{
				//get post data
				$PenName = $_POST['PenName'];
				$Password = $_POST['Password'];
				$Email = $_POST['Email'];
							
				$this->Session->setFlash('Save Complete');
						
				$this->User->create();
				$this->User->save(array(
					'pen_name' => $PenName,
					'password' => $Password,
					'email' => $Email,
					'register_date' => date('Y-m-d G:i:s'),
					'display_image_name' => '/files/seichichan/'.$PenName.'_display.jpg'					
				));
				
				$this->redirect(array(
						'controller' => 'Article',
						'action' => 'home'
				));								
			}
			//validate
			if($this->request->data['User']['Pen Name']==""||
			$this->request->data['User']['Password']==""||
			$this->request->data['User']['Email']=="")
			{
				$this->Session->setFlash('Every field must not empty');
				$this->redirect(array('action' => 'Register'));
			}
			
			if($_FILES['DisplayImage']['error'])
			{
				$this->Session->setFlash('Please upload image');
				$this->redirect(array('action' => 'Register'));
			}
			
			//get post data
			$PenName = $this->request->data['User']['Pen Name'];
			$Password = $this->request->data['User']['Password'];
			$Email = $this->request->data['User']['Email'];
			
			//save image
			$DisplayFilename = 'img/'.$PenName.'_display.jpg';
			$ImageLink=rename($_FILES['DisplayImage']['tmp_name'],WWW_ROOT.$DisplayFilename);
			
			//set data
			$this->set('PenName',$PenName);
			$this->set('Password',$Password);
			$this->set('Email',$Email);
			$this->set('DisplayImage',$PenName.'_display.jpg');
						
			$this->render('register_confirm');
		}//end else if
				
	}// end register function
	
	public function Login($error_message = null){
		
		$this->set('UserId',"");
		$this->set('check',1);
		
		//show error message when session time out
		$this->Session->setFlash($error_message,'default',array(
				'class' => 'bg-danger'
		));
		
		if($this->request->data)
		{
			//get post data from login.ctp
			$PenName = $this->request->data['User']['PenName'];
			$Password = $this->request->data['User']['Password'];
			
			//get data from User table
			$Rows = $this->User->find('count');
			$UserData = $this->User->find('all');
			
			//loop check PenName and Password
			for($i=0;$i<$Rows;$i++)
			{
				//match case
				if($UserData[$i]['User']['pen_name']==$PenName&&
					$UserData[$i]['User']['password']==$Password)
				{
					$this->Session->write('UserId',$UserData[$i]['User']['user_id']);
					$this->Session->setFlash("Login success",'default',array(
						'class' => 'bg-success'
					));
					$this->redirect(array(
						'controller' => 'Article',
						'action' => 'home'	
					));
				}
				//mismatch case
				else
				{
					$this->Session->setFlash('PenName or Password are incorrect','default',array(
						'class' => 'bg-danger'
					));
				}
			}//end for loop
			
		}//end if request data 

	}// end login function
	
	public function Logout(){
		$this->Session->delete('UserId');
		$this->redirect(array(
			'controller' => 'Article',	
			'action' => 'home'
		));
	}
	
	public function ProfileSetting(){
		
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		$UserData = $this->User->findByUserId($UserId);
		
		$PenName = $UserData['User']['pen_name'];
		$Password = $UserData['User']['password'];
		$Email = $UserData['User']['email'];
		
		$this->set('UserData',$this->User->findByUserId($UserId));
		
		if($this->request->is('post'))
		{
			//validate if every field is null
			if($this->request->data['User']['Pen Name'] == "" 
				||$this->request->data['User']['Password'] == ""
				||$this->request->data['User']['Email'] == "")
			{
				$this->Session->setFlash('Every field must not empty ');
				$this->redirect(array('action' => 'ProfileSetting'));
			}
			
			//update user data //not work?
			$this->User->id = $UserId;
			$this->User->save($this->request->data);
			var_dump($this->request->data);
			
			$NewPenName = $this->request->data['User']['Pen Name'];
			$NewPassword = $this->request->data['User']['Password'];
			$NewEmail = $this->request->data['User']['Email']; 
			
			//update image
			if($_FILES['display_image'])
			{
				//error_reporting(0);
				$DisplayFilename = '/files/seichichan/'.$NewPenName.'_display.jpg';
				$ImageLink=rename($_FILES['display_image']['tmp_name'],WWW_ROOT.$DisplayFilename);
			}
			
			
			//save old and new PenName			
			$CommentFeilds = array(
					'pen_name' => "'$NewPenName'"				
			);
			$CommentConditions = array(
					'pen_name' => "$PenName"
			);
			
			$UserFeilds = array(
					'pen_name' => "'$NewPenName'",
					'password' => "'$NewPassword'",
					'email' => "'$NewEmail'"
			);
			$UserConditions2 = array(
					'pen_name' => "$PenName",
					'password' => "$Password",
					'email' => "$Email"
			);
			
			$this->Comment->updateAll($CommentFeilds, $CommentConditions);
			$this->User->updateAll($UserFeilds, $UserConditions2);
			
			
			
		}//end if post request
		
	}//end ProfileSetting function
	
	function UserPage($UserId = null){
		
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		$this->set('UserData',$this->User->findByUserId($UserId));
		
		$UserArticle = $this->Article->find('all',array(
			'conditions' => array('Article.user_id' => $UserId)
		));
		$UserArticleCount = $this->Article->find('count',array(
				'conditions' => array('Article.user_id' => $UserId)
		));
		
		$this->set('ArticleData',$UserArticle);
		$this->set('ArticleDataCount',$UserArticleCount);
		
	
	}
	
}//end class

?>























