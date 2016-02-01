<style type="text/css" media="all">
img{
//max-height:200px;
//max-width:200px;
}	
</style>

<!-- Topic:Search -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Search
			<small>Put keyword of article for search</small>
		</h1>			
	</div>
</div>

<!--Form for Search -->
<?php
echo $this->Form->create('Article',array(
	'type' => 'post',
	'url' => array('controller' => 'Article','action' => 'Search'),
));
?>

<!--search field -->
<div class="form-group">
	<input class="search_bar form-control" 
		 name="data[Article][search]" 
		 type="search"
		  placeholder="Title Name" 
	/>
</div>

<!--search button -->
<?php	
echo $this->Form->input('Search',array(
	'type' => 'submit',
	'label' => false,
	'id' => 'search_button',
	'class' => 'btn btn-primary'
	));
echo $this->Form->end();
?>

<!-- Topic:List of Article -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">List of Article
			<small>click on article name for detail</small>
		</h1>			
	</div>
</div>

<!-- loop for show article -->
<?php
for($i=$ArticleCount-1;$i>=0;$i--)
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

<hr />

<?php 	
}//end for 
?>

