<!-- This is View -->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Match Location
			<small>Match between Location that you register and location that you choose for create article</small>
		</h1>			
	</div>
</div>

<form method="post">

<?php
for($i=0;$i<$ArticleContentCount;$i++)
{
?>

<div class="row">
	<div class="col-md-6 portfolio-item">	
		<h4><?php echo $ArticleContentData[$i]['ArticleContent']['article_location_name'];	?></h4>
	</div>	

	<input type="hidden" name="article_location_name_<?php echo $i; ?>" value="
	<?php echo $ArticleContentData[$i]['ArticleContent']['article_location_name']; ?>">
	<input type="hidden" name="article_location_detail_<?php echo $i; ?>" value="
	<?php echo $ArticleContentData[$i]['ArticleContent']['detail']; ?>">

 	<div class="col-md-6 portfolio-item">
		<select class="form-control" name="ArticleLocation_<?php echo $i ?>">

		<?php 
		for($l=0;$l<$LocationCount;$l++)
		{
		?>
			<option name="test" value="<?php echo $LocationData[$l]['Location']['location_id'] ?>">
			<?php echo $LocationData[$l]['Location']['location_memo'] ?></option><br/>

		<?php 
		}//end loop
		?>		
		</select>
	</div>
	<!-- end /.col-md-6 -->

</div>
<!--end /.row -->

<hr/>

<?php	
}//end loop for	
?>	

<input type="submit" class="btn btn-primary" /> 

</form>




