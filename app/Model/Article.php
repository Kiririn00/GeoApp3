<?php
//this is model
class Article extends AppModel{
	public $validate = array(
		
			'file' => array(
				'required' => true
		)
	);
}

?>