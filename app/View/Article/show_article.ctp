<!-- this is view -->
<style>
#map-canvas{
	height: 500px;
        margin: 0px;
        padding: 0px
}
</style>

<!-- import Geolocation V3 -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

<?php
echo $this->Html->css('jquery.excoloSlider');
echo $this->Html->script('location_image');
echo $this->Html->script('jquery.excoloSlider.min');
echo $this->Html->script('Comment');
echo $this->Html->script('ResultLocation');
?>

<!--Prepare for image slide --> 
<script>
$(function () {
    $("#slider").excoloSlider();
});
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $ArticleData['Article']['article_title']; ?>
		</h1>			
	</div>
</div>

<h3>
<?php echo $ArticleData['Article']['summary']; ?>
</h3>	

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Geolocation
			<small>Please click on mark in the map for see location detail</small>
		</h1>			
	</div>
</div>


<!-- show map -->
<div id="map-canvas"></div>

<script type="text/javascript">
	init(<?php echo $ArticleId ?>,<?php echo $ArticleLocationCount ?>);
</script>
<script type="text/javascript">
	CallComment(<?php echo $ArticleId; ?>);
</script>

<hr />

<!--show location information -->
<?php
for($i=0;$i<$ArticleContentCount;$i++)
{
$location_number = $i+1;
?>
<h3>
	<?php 
	echo "Location".$location_number.": ".$ArticleContentData[$i]['ArticleContent']['article_location_name']."<br/>";
	?>
</h3>
<h4>
	<?php
	echo $ArticleContentData[$i]['ArticleContent']['detail']."<br/>";
	?>
</h4>
<?php }//end loop ?>

<hr />

<!--Show image of location -->
<div id="slider">
	<?php for($l=0;$l<$ArticleContentImageCount;$l++){ ?>
		
		<?php
		echo $this->Html->image($ArticleContentImageData[$l]['ArticleContentImage']['image_name']);	    
		?>
		    	    
	<?php } //end for loop by ArticleContentCount ?>
</div>
<!-- end div location -->

<!--Show video of location -->
<div class="row">
	<div class="col-lg-12">
		<h3>Video</h3>
		<div class='embed-responsive embed-responsive-16by9'>
		<?php 
		echo $this->Html->media('video/'.$ArticleId.'_article.mp4', array(
		     'fullBase' => true,
		     'text' => 'Fallback text',

		)); 
		?>
		</div>
	</div>
</div>

<!-- Show sound of location -->
<div class="row">
	<div class="col-lg-12">
		<h3>Sound</h3>
		<?php 
		echo $this->Html->media('sound/'.$ArticleId.'_article.mp3',array(
			'fullBase' => true,
			'type' => 'audio/mpeg',
			'text' => 'test',
			'controls' 
		)); 
		?>
	</div>
</div>


<!-- Comment zone  -->
<?php
if($UserId!="")
{	 
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Comment
			<small>You can comment by put text in field and click submit</small>
		</h1>			
	</div>
</div>

<!--comment out put -->
<div id="get_comment"></div>

<hr/>

<form id="data" method="post" >
	<div class="form-group">
		<textarea id='textarea' class="form-control"  name="comment"></textarea>
	</div>	
	<input type="hidden" name="article_id" value="<?php echo $ArticleId; ?>">    
		
	<button class="btn btn-primary" onclick="setTimeout('CallComment(<?php echo $ArticleId; ?>),1000');">
    		Submit
    	</button>
</form>

<?php
}//end if 
?>

	
<script>	
 $("form#data").submit(function(){
 		var formData = new FormData ($(this)[0]);

 		$.ajax({
 			url: "/geoapp/Article/Comment",
 			type: "POST",
 			data: formData,
 			async: false,
 			success: function(data){
 	            if($('#textarea').val()=="" )
 	            {
 	              alert('Please input text or image');
 	              return;
 	            }
 	           $('form#data').each(function(){
                   this.reset();
               });
 			},
 			cache: false,
 			contentType: false,
 			processData: false
 		});
       
 		return false;

 	}); 
</script>
 
 
 

