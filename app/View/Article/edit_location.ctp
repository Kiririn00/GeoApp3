<!-- This is view -->

<h2>Please Select Location that match your memo</h2>

<h4>Location Name</h4>
<form method="post">
<?php
for($i=0;$i<$ArticleContentCount;$i++)
{
	echo $ArticleContentData[$i]['ArticleContent']['article_location_name'];	
?>	
	<input type="hidden" name="article_location_name_<?php echo $i; ?>" value="<?php echo $ArticleContentData[$i]['ArticleContent']['article_location_name']; ?>">
	<select name="ArticleLocation_<?php echo $i; ?>">
<?php 
	for($l=0;$l<$LocationCount;$l++)
	{
?>

<option name="test" value="<?php echo $LocationData[$l]['Location']['location_id'] ?>"
<?php
	for($k=0;$k<$ArticleLocationCount;$k++)
	{	
 		if( $LocationData[$l]['Location']['location_memo']==$ArticleLocationData[$k]['ArticleLocation']['location_memo']) 
 		{
 			echo "selected";
 		}	
	}	
 ?>
>
<?php echo $LocationData[$l]['Location']['location_memo'] ?></option><br/>
<?php 
	}
		
	echo "</select><br/>";
}//end loop for	
?>	

<br/>
<input type="submit">


</form>

