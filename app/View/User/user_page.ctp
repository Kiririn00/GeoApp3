<!-- This is View -->
<style type="text/css" media="all">
img{
max-height:200px;
max-width:200px;
}	
</style>
<div id="topic_mypage">My Page</div>
<div id="topic_pen_name">PenName: <?php echo $UserData['User']['pen_name']; ?></div>
<div id="topic_profile_setting">	
	<?php
		echo $this->Html->link(
				'Profile Setting',
				array(
						'controller' => 'User',
						'action' => 'ProfileSetting'
				)
		);
	?>
</div>



<br/><br/>

<div id="user_page_container">
	<?php
	for($i=0;$i<$ArticleDataCount;$i++)
	{
	?>	
		<!-- article image -->
		<?php 
			echo $this->Html->image($ArticleData[$i]['Article']['article_image_name'],array(
				'id' => 'article_image'
			)); 
		?>
		<br/>

		<!-- article topic -->
		<?php
			echo $this->Html->link($ArticleData[$i]['Article']['article_title'],array(
				'controller' => 'article',
				'action' => 'ShowArticle',$ArticleData[$i]['Article']['id']
			));				
		?>
		<br/>		

		<!-- Edit button -->
		<?php
			echo $this->Html->link(
					'EditArticle',
					array(
							'controller' => 'Article',
							'action' => 'EditArticle',$ArticleData[$i]['Article']['id']
					)
			);
		?>
		&nbsp;
		<!-- delete button -->
		<?php
			echo $this->Html->link(
					'Delete',
					array(
							'controller' => 'Article',
							'action' => 'Delete',$ArticleData[$i]['Article']['id']
					)
			);
		?>

		<br/><br/><br/>
		
	<?php 
	}//end for loop
	?>

</div><!-- end div user_page_container -->







