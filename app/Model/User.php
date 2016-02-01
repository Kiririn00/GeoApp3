<?php
//this is model
class User extends AppModel{
	public $primaryKey = 'user_id';
	
	public $validate = array(
		'pen_name' => array(
			'require' => array(
				'rule' => 'notEmpty'	
		))
		
	);
	/*
	public $validate = array(

		'first_name' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'กรุณากรอกชื่อจริงด้วยครับ'
		)),
	
	
	 */
	
}

?>