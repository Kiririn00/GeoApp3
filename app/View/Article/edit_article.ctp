<!-- This is view -->

<div id="edit_article_container">

<div id="topic">Edit Article</div>

<div id="line"></div>
<form enctype="multipart/form-data" method="post">

Title
<br/>
<input type="text" name="article_title" value="<?php echo $ArticleData['Article']['article_title']; ?>" />
<br/>
<!--
Anime Title
<br/>
<input type="text" name="anime_title" value="<?php echo $AnimeData['Anime']['anime_title'] ?>" />
<br/>
-->
Summary Detail
<br/>
<input type="text" name="summary" value="<?php echo $ArticleData['Article']['summary']; ?>" />
<br/>

Article Image
<br/>
<?php
echo $this->Html->image($ArticleData['Article']['article_image_name'],array('id' => 'article_image'));
?>
<br/>

<br/>
<input type="file" name="ArticleImage" />
<br/>

<?php for($i=0;$i<$ArticleContentCount;$i++){ ?>

Location Name 
<br/>
<input type="text" name="location_name_<?php echo $i; ?>" 
value="<?php echo $ArticleContentData[$i]['ArticleContent']['article_location_name'] ?>" />
<br/>

Location Detail
<br/>
<textarea rows="4" cols="50" name="article_detail_<?php echo $i; ?>">
<?php echo $ArticleContentData[$i]['ArticleContent']['detail']; ?>
</textarea>
<br/>

Upload Location image
<br/>
<?php
 
for($l=0;$l<$ArticleContentImageCount;$l++){

	if($ArticleContentData[$i]['ArticleContent']['id'] == $ArticleContentImageData[$l]['ArticleContentImage']['article_content_id'])
	{

?>
	<br/>
	<?php
		echo $this->Html->image($ArticleContentImageData[$l]['ArticleContentImage']['image_name'],array(
			'id' => 'article_image'
		));
	?>

<?php
echo $this->Form->input('files.', array(
		'type' => 'file', 'multiple',
		'name' => 'data[ArticleImage_'.$i.'][]'
));
	 }//end if
 
 }//end for
 
 ?>
 
<br/>

<?php }//end for loop ?>
<input type="submit">

</form>

</div>
<!-- end div edit_article_container -->
