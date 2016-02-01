
Data from Controller
<br/><br/>
<?php 
echo $Latitude = "Latitude: ".$LocationData['Location']['latitude']."<br/>";
echo $Longitude = "Longitude: ".$LocationData['Location']['longitude']."<br/>";
?>

<!-- Geolocation set current location script -->
<?php 
echo $this->Html->script('ResultLocation', array('inline' => false));
 ?>
 
 <!-- show map -->
<div id="map-canvas"></div>






















