<!-- This is view -->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Search
			<small>This is seatch result from keyword "<?php echo $SearchResult; ?>"</small>
		</h1>			
	</div>
</div>


<?php
//loop for to find Anime name that match to keyword
	
	//loop for to find Article data that match Anime id
for($i=0;$i<$ArticleCount;$i++)
	{	
?>	
<!-- aritcle -->
<div class="row">

	<div class="col-md-7">
		<?php
			echo $this->Html->image($ArticleData[$i]['Article']['article_image_name'],array(
				'class' => 'img-responsive',

			));
		?>

	</div>
	<!-- end /.col-md-7 -->
	
	<div class="col-md-5">
		<!-- Article Topic -->
		<h3>
		<?php
			echo $this->Html->link($ArticleData[$i]['Article']['article_title'],array(
				'controller' => 'Article',
				'action' => 'ShowArticle',$ArticleData[$i]['Article']['id']
			));
		?>
		</h3>
		
		<!-- Article Intro -->
		<h4>
			<?php 
			echo $ArticleData[$i]['Article']['summary'];		
		       	?>
		</h4>

		<!-- Article Date -->
		<p>
		<div id="article_date">
			<?php
				echo $ArticleData[$i]['Article']['article_date'];
			?>
		</div>
			
		<!-- Comment Amount -->
		<?php
			$Count=0;
			for($k=0;$k<$CommentCount;$k++)
			{
				if($ArticleData[$i]['Article']['id']==$CommentData[$k]['Comment']['article_id'])
				{
					$Count++;
				}
				
			}//end loop			
		?>		
		<div id="comment_amount_line">
			<div id="comment_amount"><?php echo $Count; ?> Comment</span>
			</div>
		</div>
		</p>

	</div>
	<!-- end /.col-md-5 -->

</div>
<!-- end /.row-->

<hr/>
<?php 		
}//end loop for by ArticleCount
?>

