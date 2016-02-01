<!-- this is view -->
<?php
echo $this->Html->script('AddRemoveField');
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Create New Article
			<small>Put information of your location to create article</small>
		</h1>			
	</div>
</div>


<form enctype="multipart/form-data" method="post">

	<!--//////////////// new article field //////////////////////////-->
	
	<div class="form-group">
		<label>New Title</label>
		<input type="text" class="form-control" name="article_title" required />
	</div>

	<div class="form-group">
		<label>Summary Detail</label>
		<input type="text" class="form-control" name="summary" required />
	</div>

	<div class="form-group">
		<label>Article Image</label>
		<input type="file"  name="ArticleImage" required />
	</div>
	
	<div class="form-group">
		<label>Article Video</label>
		<input type="file"  name="ArticleVideo" >
	</div>
	
	<div class="form-group">
		<label>Article Sound</label>
		<input type="file"  name="ArticleSound" >
	</div>

	<hr/>
	<!--//////////////// new article content set field //////////////////////////-->

	<div class="form-group">
		<label>Location Name</label>
		<input type="text" class="form-control" name="location_name_0" required />
	</div>

	<div class="form-group">
		<label>Location Detail</label>
		<textarea rows="4" cols="50" class="form-control" name="article_detail_0" required></textarea>
	</div>

	<div class="form-group">
		<label>Upload Location Image</label>
		<?php 
			echo $this->Form->input('Article.file', array(
				'type' => 'file', 'multiple',
				'name' => 'ArticleImage_0[]',
				'label' => false
			)); 
		?>
		<input type="file" multiple="multiple" name="imagefile[]" >  

	</div>




	<div id="PasteImageField" class="1"></div>

	<div id="PasteField"></div>
	<div id="addfield_cover"><a href="#" id="AddField">Add New Location <br/> <span id="jp">登録場所を増やす</span></a></div>
	<input type="hidden" name="set_feild_count" value="1">
	<br/><br/>

	<input type="submit" class="btn btn-primary" /> 


</form>






















