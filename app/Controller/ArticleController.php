<?php
//this is controller
class ArticleController extends AppController{
	
	//set layout for all action in this controller
	//var $layout = 'masterLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text','Session' );
	//set object model
	var $uses = array('Location','Article','ArticleContent','ArticleContentImage','Anime','User','ArticleLocation','Comment','Ching'); 
	//set JSON
	public $components = array('RequestHandler','Session');
	
//action
	
	public function index(){		
		return $this->redirect(
			array('action' => 'Home')
		);
	}

	public function Test(){

		$this->layout = ('default_backup');
		
		if($this->request->is('post'))
		{
			$exif = exif_read_data($_FILES["ArticleImage_0"]["tmp_name"][0], 0, true);
			if($exif){
				//var_dump($exif); //exifの全情報
				$this->set('exif',$exif);
			}else{
				echo "Exif情報がありません";
			}
			
		}
		
	}
	
	public function Test2(){
		
	}
	
	public function DeleteAll(){
		
		$this->Article->deleteAll(array('1 = 1'));
		$this->ArticleContent->deleteAll(array('1 = 1'));
		$this->redirect(array(
			'action' => 'Home'	
		));
	}
	
	public function Home(){
		//echo $check = $this->Session->read('check');
		$this->set('UserId',$this->Session->read('UserId'));
		
		$this->set('UrlName',$this->U);
		
		$this->set('ArticleData',$this->Article->find('all'));
		$this->set('ArticleCount',$this->Article->find('count'));
		$this->set('UserData',$this->User->find('all'));
		$this->set('UserCount',$this->User->find('count'));
		
		$AnimeData = $this->Anime->find('all');
		$AnimeCount = count($AnimeData);
		
		$this->set('AnimeData',$AnimeData);
		$this->set('AnimeCount',$AnimeCount);

		//Count comment
		$CommentData = $this->Comment->find('all');
		$this->set('CommentData',$CommentData);
		$this->set('CommentCount',count($CommentData));
		$CommentCount = count($CommentData);
		
		//sort amount of Comment to find Article
		
		//find all of article id into array
		for($i=0;$i<$CommentCount;$i++)
		{			
			$CommentArticle[$i] = $CommentData[$i]['Comment']['article_id'];
		}
		
		//count the frequency of amount of array
		$CommentAmount = array_count_values($CommentArticle);
		//sort array from high to low
		arsort($CommentAmount);
		//change format array find the id of Article high to low
		$Ranking = array_keys($CommentAmount);
		
		$this->set('Ranking',$Ranking);
		$ArticleContentImageData = $this->ArticleContentImage->find('all');
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		$this->set('ArticleContentImageCount',count($ArticleContentImageData));
								
	}
	
	public function Show(){
		$this->set('LocationData',$this->Location->findByLocationId(10));
		
		$LocationJSON = $this->Location->find('all');
		$ArticleLocationJSON = $this->ArticleLocation->find('all');
		$ArticleContentJSON = $this->ArticleContent->find('all');
		
		$this-> set(compact('LocationJSON'));
		$this-> set(compact('ArticleLocationJSON'));
		$this-> set(compact('ArticleContentJSON'));
		
		$this->set('_serialize',array('LocationJSON','ArticleLocationJSON','ArticleContentJSON'));
	}
	
	public function NewArticle(){
		//read session of user id
		$UserId = $this->Session->read('UserId');
		//if user id session is null that mean user still not login yes. So redirect to login page with error message
		if($UserId == null){
			
			$error_meage = 'Session time out please login again';
			$this->redirect(array(
				'controller' => 'User',	
				'action' => 'Login',$error_meage	
			));
			
		}
		//set user id to view
		$this->set('UserId',$UserId);
		
		//set Location all data by UserId
		$this->set('LocationData',$this->Location->find('all',array(
			'conditions' => array('Location   .user_id' => $UserId)
		)));
		
		//set count number of row by UserId
		$this->set('LocationCount', $this->Location->find('count',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		//if submit form (get post data)
		if($this->request->is('post'))
		{

			//------------------- this is for save to Article Model  -----------------------------------//
			
			//get post data of Article 
			$ArticleTitle = $_POST['article_title'];
			$Summary = $_POST['summary'];
			
			//insert data to Article model
			$this->Article->create();
			$this->Article->save(array(
					'user_id' => $UserId,
					'article_title' => $ArticleTitle,
					'summary' => $Summary,
					'article_date' => date('Y-m-d G:i:s'),
			));
							
			$ArticleId = $this->Article->getLastInsertId();
			
			//validate image
			if($_FILES['ArticleImage']['error'])
			{
				//for not show error 
			}//end if
			//save image for Article
			else
			{
				$ArticleFilename = 'img/'.$ArticleId.'_article.jpg';//new image name
				$ImageLink=rename($_FILES['ArticleImage']['tmp_name'],WWW_ROOT.$ArticleFilename);//rename and save to directory
				
				$this->Article->ArticleId = $ArticleId;
				$this->Article->save(array(
						'article_image_name' => $ArticleId.'_article.jpg',			
				));
				
				//check video
				if($_FILES['ArticleVideo']['error']){
					//no video
				}
				//have video case
				else{
					
					$ArticleFilename = 'files/video/'.$ArticleId.'_article.mp4';
					$ImageLink=rename($_FILES['ArticleVideo']['tmp_name'],WWW_ROOT.$ArticleFilename);
						
					$this->Article->ArticleId = $ArticleId;
					$this->Article->save(array(
						'article_video_name' => $ArticleId.'_article.mp4'	
					));
				}
				
				//check sound
				if($_FILES['ArticleSound']['error']){
					//no sound	
				}
				//have sound case
				else{
					
					$ArticleFilename = 'files/sound/'.$ArticleId.'_article.mp3';
					$ImageLink=rename($_FILES['ArticleSound']['tmp_name'],WWW_ROOT.$ArticleFilename);
					
					$this->Article->ArticleId = $ArticleId;
					$this->Article->save(array(
							'article_sound_name' => $ArticleId.'_article.mp3'
					));
					
				}//end else				
			}//end else

			//---------- This is for save to ArticleContent and ArticleContentImage Model----------------------------------//
			
			//get post data of ArticleContent and ArticleContentImage 
			echo $SetFeildCount = $_POST['set_feild_count'];
			
			//Validate image for ArticleContentImage
			$FileArray = $_FILES["ArticleImage_0"];
			
			//Save text data to ArticleContent

			if($FileArray=="")
			{}
			else{ 
				//Save to ArticleContent
				for($i=0;$i<$SetFeildCount;$i++)
				{
					//get location name's post data
					$LocationName = $_POST['location_name_'.$i];
					//get detail's post data
					$ArticleDetail = $_POST['article_detail_'.$i];
					//get location's table detail
					$location_data = $this->Location->find('all');
					$location_data_count = $this->Location->find('count');
					/*
							$ArticleContentData = $this->ArticleContent->find('all',array(
							'conditions' => array('ArticleContent.article_id' => $ArticleId)
						)); 
					*/
					
											
					$this->ArticleContent->create();
					$this->ArticleContent->save(array(
							'article_id' => $ArticleId,
							'article_location_name' => $LocationName,
							'detail' => $ArticleDetail,
							'article_content_date' => date('Y-m-d G:i:s')
					));
					
					$ArticleContentId = $this->ArticleContent->getLastInsertId();
					
					$FileArray = $_FILES["ArticleImage_".$i];
					$FileCount=count($FileArray);
					debug($FileArray);
					
					
					//Save to ArticleContentImage
					for($l=0;$l<1;$l++)
					{
						$this->ArticleContentImage->create();
						$ArticleContentFilename = '/img/article_'.$ArticleId."_set".$i."_no".$l.".jpg";
						
						debug(WWW_ROOT.$ArticleContentFilename);
						debug($_FILES["ArticleImage_0"]["tmp_name"]);
						$ImageLink=rename($_FILES["ArticleImage_".$i]["tmp_name"][0],WWW_ROOT.$ArticleContentFilename);
												
						$this->ArticleContentImage->save(array(
							'article_content_id' => $ArticleContentId,
							'article_id' => $ArticleId,	
							'image_name' => $ArticleContentFilename
						));
						
						//get exif data
						$exif = exif_read_data($_FILES["imagefile"]["tmp_name"][0], 0, true);
						
						//$exif = exif_read_data($_FILES["ArticleImage_0"]['tmp_name'][0], 0, true);//ArticleImage_0[]
						debug("have exif");
						
						//check image have lat,log or not?
						if($exif['GPS']){
							//have exif_data(gps data)
							//@debug($exif['GPS']['GPSLatitude']);
							debug("have exif");
							//get GPS's Latitude
							$degree_cal_1 = before('/',$exif['GPS']['GPSLatitude'][0]);
							$degree_cal_2 = after('/',$exif['GPS']['GPSLatitude'][0]);
							$degree = $degree_cal_1 / $degree_cal_2;
							
							$minutes_cal_1 = before('/',$exif['GPS']['GPSLatitude'][1]);
							$minutes_cal_2 = after('/',$exif['GPS']['GPSLatitude'][1]);
							$minutes = $minutes_cal_1 / $minutes_cal_2;
														
							$seconds_cal_1 = before('/',$exif['GPS']['GPSLatitude'][2]);
							$seconds_cal_2 = after('/',$exif['GPS']['GPSLatitude'][2]);
							$seconds = $seconds_cal_1 / $seconds_cal_2;
							
							$latitude = $degree+($minutes/60)+($seconds/3600);
							
							//get GPS's Logitude
							$degree_cal_1 = before('/',$exif['GPS']['GPSLongitude'][0]);
							$degree_cal_2 = after('/',$exif['GPS']['GPSLongitude'][0]);
							$degree = $degree_cal_1 / $degree_cal_2;
							
							$minutes_cal_1 = before('/',$exif['GPS']['GPSLongitude'][1]);
							$minutes_cal_2 = after('/',$exif['GPS']['GPSLongitude'][1]);
							$minutes = $minutes_cal_1 / $minutes_cal_2;
							
							$seconds_cal_1 = before('/',$exif['GPS']['GPSLongitude'][2]);
							$seconds_cal_2 = after('/',$exif['GPS']['GPSLongitude'][2]);
							$seconds = $seconds_cal_1 / $seconds_cal_2;
							
							$longitude = $degree+($minutes/60)+($seconds/3600);
							
							for($k=0;$k<$location_data_count;$k++){
								if(
										$latitude<$location_data[$k]['Location']['latitude']+0.0027 || $latitude<$location_data[$k]['Location']['latitude']-0.0027 &&
										$longitude<$location_data[$k]['Location']['longitude']+0.0027 || $longitude<$location_data[$k]['Location']['longitude'][$k]-0.0027
								){
									$this->ArticleLocation->create();
									$this->ArticleLocation->save(array(
											'article_id' => $ArticleId,
											'article_location_name' => $LocationName,
											'detail' => $ArticleDetail,
											'location_id' => $location_data[$k]['Location']['location_id'],
											'location_memo' => $location_data[$k]['Location']['location_memo'],
											'latitude' => $latitude,
											'longitude' => $longitude
									));
									break;
								}//end if
								else{
									debug('not match');
								}//end else
								
							}//end loop for
							/*
							$this->ArticleLocation->create();
							$this->ArticleLocation->save(array(
									'article_id' => $ArticleId,
									'article_location_name' => $LocationName,
									'detail' => $ArticleDetail,
									'location_id' => $location_data['location_id'],
									'location_memo' => $location_memo['location_memo'],
									'latitude' => $latitude,
									'longitude' => $longitude
							));
							*/
								
						}
						else{
							//not have exif_data
						}
					}//end for loop FileCount
					
					$this->Session->write('ArticleId',$ArticleId);
					
				}//end　for loop Set
				
			}//end else	
			
			//When Everything are done
				
			$this->redirect(array(
				'action' => 'Home'
			));
			
											
		}//end if post request
		
	}//end function
	
	
	public function SelectLocation(){
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		$ArticleId = $this->Session->read('ArticleId');

		$ArticleContentData = $this->ArticleContent->find('all',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentData',$ArticleContentData);
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$ArticleContentCount = $this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$this->set('LocationData',$this->Location->find('all',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		$this->set('LocationCount',$this->Location->find('count',array(
			'conditions' => array('Location.user_id' => $UserId)
		)));
		
		
		if($this->request->is('post'))
		{
			for($i=0;$i<$ArticleContentCount;$i++)
			{
				echo "<br/>location id:".$_POST['ArticleLocation_'.$i];
				$LocationId = $_POST['ArticleLocation_'.$i];
				$ArticleLocationName = $_POST['article_location_name_'.$i];
				$ArticleLocationDetail = $_POST['article_location_detail_'.$i];
				$LocationData = $this->Location->findByLocationId($LocationId);
				
				$Lat = $LocationData['Location']['latitude'];
				$Long = $LocationData['Location']['longitude'];
				$LocationMemo = $LocationData['Location']['location_memo'];
				
				$this->ArticleLocation->create();
				$this->ArticleLocation->save(array(
					'article_id' => $ArticleId,
					'article_location_name' => $ArticleLocationName,
					'detail' => $ArticleLocationDetail,		
					'location_id' => $LocationId,
					'location_memo' => $LocationMemo,	
					'latitude' => $Lat,
					'longitude' => $Long		 	
				));
								
			}//end for loop
			
			//everything is done
			$this->redirect(array(
				'action' => 'home'
			));
		
		}
		
	}//end SelectLocation function
		
	public function ShowArticle($ArticleId = null)
	{
		$this->set('UserId',$this->Session->read('UserId'));
		$this->set('ArticleId',$ArticleId);
		
		///////////////////////////////////////////////////////////////////////
		
		$ArticleData = $this->Article->findByid($ArticleId);
		
		$this->set('ArticleData',$this->Article->findByid($ArticleId));
				
		$AnimeData = $this->Anime->findByAnimeId($ArticleData['Article']['anime_id']);
		
		$this->set('AnimeData',$AnimeData);
		
		$this->set('ArticleContentData',$this->ArticleContent->find('all',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleLocationCount', $this->ArticleLocation->find('count',array(
			'conditions' => array('ArticleLocation.article_id' => $ArticleId )	
		)));
		
		$ArticleContentImageData = $this->ArticleContentImage->find('all',array(
			'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		$this->set('ArticleContentImageCount',count($ArticleContentImageData));
	}
	
	public function Comment()
	{
		$UserId = $this->Session->read('UserId');
				
		$CommentJSON = $this->Comment->find('all');
		
		$this-> set(compact('CommentJSON'));
		
		$this->set('_serialize',array('CommentJSON'));
		
		if($this->request->is('post'))
		{
			$Comment = $_POST['comment'];
			$ArticleId = $_POST['article_id'];
			$PenName = $this->User->findByUserId($UserId);
			
			if($Comment != "")
			{	
				$this->Comment->create();
				$this->Comment->save(array(
					'article_id' => $ArticleId,
					'user_id' => $UserId,
					'pen_name' => $PenName['User']['pen_name'],	
					'comment' => $Comment,
					'comment_date' => date('Y-m-d G:i:s')	
				));
			}
		}//end request port
		
	}//end Comment function
	
	public function Search()
	{
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		
		if($this->request->is('post'))
		{
			//get search text
			$SearchResult = $this->request->data['Article']['search'];
			
			// add % for use sql
			$SearchSQL = "%".$SearchResult."%";
			
			//search array data from Article and Article content
			$ArticleSearchArray = $this->Article->find('all',array(
				'conditions' => array(
					'OR' => array(
					'Article.article_title LIKE' => $SearchSQL,
					'Article.summary LIKE' => $SearchSQL,	
					)
				)
					
			));
			debug($ArticleSearchArray);
			
			//set search text
			$this->set('SearchResult',$SearchResult);
			
			//find Anime Keyword that match 
			$AnimeResult = $this->Anime->find('all');
			$AnimeResultCount = count($AnimeResult);
						
			//var_dump($AnimeResult);
			
			//check search result that
			
			//no result 
			if(empty($ArticleSearchArray))
			{
				$this->Session->setFlash("No Search Result");
				$this->set('AnimeCount',0);
			}
			//have result
			else if(!empty($ArticleSearchArray))
			{
				$this->set('ArticleData',$ArticleSearchArray);
				$this->set('ArticleCount',count($ArticleSearchArray));
				
				/////////////////////////////////////////////////////////////
				/*
				$this->set('ArticleData',$this->Article->find('all'));
				$this->set('ArticleCount',$this->Article->find('count'));
				
				$this->set('AnimeData',$AnimeResult);
				$this->set('AnimeCount',$AnimeResultCount);
				
				$this->set('UserData',$this->User->find('all'));
				$this->set('UserCount',$this->User->find('count'));
				*/
				
				//Count comment
				$CommentData = $this->Comment->find('all');
				$this->set('CommentData',$CommentData);
				$this->set('CommentCount',count($CommentData));
				$CommentCount = count($CommentData);
				
			}			
		}//end if request post
		//case error 
		else
		{
			$this->Session->setFlash("<script>alert('Enter keyword first')</script>");
			$this->redirect(array(
				'controller' => 'Article',
				'action' => 'Home'	
			));
		}	
	
	}//end search function 
	
	public function Delete($ArticleId = null){
		
		$UserId = $this->Session->read('UserId');
		
		$ArticleData = $this->Article->findById($ArticleId);
		$ArticleContentData = $this->ArticleContent->findByArticleId($ArticleId);
		$ArticleContentImageData = $this->ArticleContentImage->findByArticleContentId($ArticleContentData['ArticleContent']['id']);
		$ArticleLocationData = $this->ArticleLocation->findByArticleId($ArticleId);
		$CommentData = $this->Comment->findByArticleId($ArticleId);		
		
		//delete image
		unlink($_SERVER['DOCUMENT_ROOT']."/app/webroot/".$ArticleData['Article']['article_image_name']);
		
		$ImageContentName = $this->ArticleContentImage->find('all',array(
								'conditions' => array('ArticleContentImage.article_id' => $ArticleId)			
							));
		$CountImageContentName = count($ImageContentName);
				
		for($i=0;$i<$CountImageContentName;$i++){
			unlink($_SERVER['DOCUMENT_ROOT']."/app/webroot".$ImageContentName[$i]['ArticleContentImage']['image_name']);
		}
		
		
		//delete text data
		$this->Article->delete($ArticleId);
		$this->Anime->delete($ArticleData['Article']['anime_id']);
		$this->ArticleContent->deleteAll(array(
			'ArticleContent.article_id' => $ArticleId
		));
		$this->ArticleContentImage->deleteAll(array(
			'ArticleContentImage.id' => $ArticleContentImageData['ArticleContentImage']['id']
		));
		$this->ArticleLocation->deleteAll(array(
			'ArticleLocation.article_id' => $ArticleId			
		),false);		
		$this->Comment->deleteAll(array(
			'Comment.article_id' => $ArticleId
		));
		
		
		$this->redirect(array(
			'controller' => 'User',	
			'action' => 'UserPage',$UserId
		));
		
				
	}//end delete function
	
	public function EditArticle($ArticleId = null)
	{
		$UserId = $this->Session->read('UserId');
		$this->set('UserId',$UserId);
		//set Article Data
		$ArticleData = $this->Article->findByid($ArticleId);
		$this->set('ArticleData',$ArticleData);
		
		//set Anime data
		$AnimeData = $this->Anime->findByAnimeId($ArticleData['Article']['anime_id']);
		$this->set('AnimeData',$AnimeData);
		
		//set ArticleContent Data
		$ArticleContentCount = $this->ArticleContent->find('count',array(
			'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		$ArticleContentData = $this->ArticleContent->find('all',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentCount',$ArticleContentCount);
		$this->set('ArticleContentData',$ArticleContentData);
		
		//set ArticleContentImage Data
		$ArticleContentImageCount = $this->ArticleContentImage->find('count',array(
			'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		$ArticleContentImageData = $this->ArticleContentImage->find('all',array(
				'conditions' => array('ArticleContentImage.article_id' => $ArticleId)
		));
		
		$this->set('ArticleContentImageCount',$ArticleContentImageCount);
		$this->set('ArticleContentImageData',$ArticleContentImageData);
		
		//debug
		/*
		var_dump($ArticleData);
		var_dump($ArticleContentData);
		var_dump($ArticleContentImageCount);
		*/
		
		if($this->request->is('post'))
		{			
			//get post data of Article and Anime model
			$ArticleTitle = $_POST['article_title'];
			//$AnimeTitle = $_POST['anime_title'];
			$Summary = $_POST['summary'];

			//update Article image
			if($_FILES['ArticleImage']['error'])
			{}
			else
			{
				$ArticleFilename = 'img/'.$ArticleId.'_article.jpg';
				$ImageLink=rename($_FILES['ArticleImage']['tmp_name'],WWW_ROOT.$ArticleFilename);
				
			}
										
			
			//update Article data
			$ArticleDataUpdate = array(
				'id' => $ArticleId,
				'article_title' => $ArticleTitle,
				'summary' => $Summary,
				'article_update_date' => date('Y-m-d G:i:s'),					
			);
			
			$this->Article->save($ArticleDataUpdate);
											
			for($i=0;$i<$ArticleContentCount;$i++)
			{
				$LocationName = $_POST['location_name_'.$i];
				$ArticleDetail = $_POST['article_detail_'.$i];
				
				//update ArticleContent Image
				$FileArray = $this->request->data['ArticleImage_'.$i];
				$FileCount=count($FileArray);
				
				//debug($FileArray);
				//debug($FileCount);
				
				if($FileArray[0]['size'] == 0){
					// do noting
				}
				else{				
					for($l=0;$l<$FileCount;$l++)
					{
						$ArticleContentFilename = 'img/article_'.$ArticleId."_set".$i."_no".$l.".jpg";
						$ImageLink=rename($FileArray[$l]['tmp_name'],WWW_ROOT.$ArticleContentFilename);
					}
				}
				
				//update ArticleContent data
				$ArticleContentDataUpdate = array(
						'id' => $ArticleContentData[$i]['ArticleContent']['id'],
						'article_id' => $ArticleId,
						'article_location_name' => $LocationName,
						'detail' => $ArticleDetail,
				);
				$this->ArticleContent->save($ArticleContentDataUpdate);
				
				//update ArticleLocation data
				$ArticleLocationData = $this->ArticleLocation->find('all',array(
						'conditions' => array('ArticleLocation.article_id' => $ArticleId)
				));
				$ArticleLocationCount = $this->ArticleLocation->find('count',array(
						'conditions' => array('ArticleLocation.article_id' => $ArticleId)
				));
					
			}//end for loop
			
			for($l=0;$l<$ArticleLocationCount;$l++)
			{
			$ArticleLocationUpdate = array(
					'id' => $ArticleLocationData[$l]['ArticleLocation']['id'],
					'article_location_name' => $_POST['location_name_'.$l],
					'detail' => $_POST['article_detail_'.$l]
			);
					$this->ArticleLocation->save($ArticleLocationUpdate);
			}
			
									
		}//end if post request
		
	}// end EditArticle function
	
	public function EditLocation($ArticleId = null){
		
		$UserId = $this->Session->read('UserId');
		
		$this->set('ArticleContentData',$this->ArticleContent->find('all',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$this->set('ArticleContentCount',$this->ArticleContent->find('count',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		)));
		
		$ArticleContentCount = $this->ArticleContent->find('count',array(
				'conditions' => array('ArticleContent.article_id' => $ArticleId)
		));
		
		$LocationData = $this->Location->find('all',array(
				'conditions' => array('Location.user_id' => $UserId)
		));
		
		$this->set('LocationData',$LocationData);
		
		$this->set('LocationCount',$this->Location->find('count',array(
				'conditions' => array('Location.user_id' => $UserId)
		)));
		
		$ArticleLocationData = $this->ArticleLocation->find('all',array(
				'conditions' => array('ArticleLocation.article_id' => $ArticleId)
		));

		$ArticleLocationCount = $this->ArticleLocation->find('count',array(
				'conditions' => array('ArticleLocation.article_id' => $ArticleId)
		));
		
		$this->set('ArticleLocationData',$ArticleLocationData);
		$this->set('ArticleLocationCount',$ArticleLocationCount);
		
		var_dump($LocationData);
		
	}//end EditLocation function

}//end class

//sub str function
function after ($this, $inthat)
{
	if (!is_bool(strpos($inthat, $this)))
		return substr($inthat, strpos($inthat,$this)+strlen($this));
};

function after_last ($this, $inthat)
{
	if (!is_bool(strrevpos($inthat, $this)))
		return substr($inthat, strrevpos($inthat, $this)+strlen($this));
};

function before ($this, $inthat)
{
	return substr($inthat, 0, strpos($inthat, $this));
};

function before_last ($this, $inthat)
{
	return substr($inthat, 0, strrevpos($inthat, $this));
};

function between ($this, $that, $inthat)
{
	return before ($that, after($this, $inthat));
};

function between_last ($this, $that, $inthat)
{
	return after_last($this, before_last($that, $inthat));
};

// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle)
{
	$rev_pos = strpos (strrev($instr), strrev($needle));
	if ($rev_pos===false) return false;
	else return strlen($instr) - $rev_pos - strlen($needle);
};


















?>
