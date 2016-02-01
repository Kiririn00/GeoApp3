<!DOCTYPE html>
<style>
      html, body, #map-canvas {
        height: 500px;
        margin: auto;
}
.controls{
	width:400px;
	height:50px;
	font-size:13pt;
}
</style>


<!-- show map and search box -->
<input id="pac-input" class="controls" type="text" placeholder="Search Box">

<div id="map-canvas"></div>

<h2>Search Map position</h2>

<form method="post" >
     
	<input type="hidden" name="latitude" value="0" />
	<input type="hidden" name="longitude" value="0" />
	
	<div class="form-group">
	<h3>Location Name</h3>
	<input type="text" class="form-control" name="location_name" placeholder ="Enter Location Name"  />
	</div>

	<div class="form-group">
	<h3>Memo</h3>
	<input type="text" class="form-control" name="memo" placeholder ="Enter Memo Name" />
	</div>

	<input type="submit" value="Save" class="btn btn-primary" />

</form>
   	

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<?php echo $this->Html->script('SearchLocation'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>



































