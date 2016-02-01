<!-- this is view of test.ctp -->
<?php
/*
echo "test1.jpg:<br />\n";
$exif = exif_read_data('/GeoApp/app/webroot/img/233_article.jpg', 'FILE');
echo $exif===false ? "No header data found.<br />\n" : "Image contains headers<br />\n";

debug($exif);
 */
header("Content-Type: text/plain; charset=utf-8");
echo $this->Form->create(false,array(
	'action' => 'Test',
	'type' => 'post',
	'enctype' => 'multipart/form-data',

));
?>

<input type="file" multiple="multiple" name="ArticleImage_0[]" >    

<?php
echo $this->Form->end('submit');

//@debug($exif);
//@var_dump($exif);
//Degrees + minutes/60 + seconds/3600
?>
<h3>GPS's data</h3>
<?php
@debug($exif['GPS']);
?>

<h3>GPS's Latitude</h3><br />
<?php
@debug($exif['GPS']['GPSLatitude']);
$degree_cal_1 = before('/',$exif['GPS']['GPSLatitude'][0]);
$degree_cal_2 = after('/',$exif['GPS']['GPSLatitude'][0]);
$degree = $degree_cal_1 / $degree_cal_2;

$minutes_cal_1 = before('/',$exif['GPS']['GPSLatitude'][1]);
$minutes_cal_2 = after('/',$exif['GPS']['GPSLatitude'][1]);
$minutes = $minutes_cal_1 / $minutes_cal_2;


$seconds_cal_1 = before('/',$exif['GPS']['GPSLatitude'][2]);
$seconds_cal_2 = after('/',$exif['GPS']['GPSLatitude'][2]);
$seconds = $seconds_cal_1 / $seconds_cal_2;

$latitude = $degree+($minutes/60)+($seconds/3600);
debug($latitude);
?>

<h3>GPS's Longitude</h3><br />
<?php
@debug($exif['GPS']['GPSLatitude']);
$degree_cal_1 = before('/',$exif['GPS']['GPSLongitude'][0]);
$degree_cal_2 = after('/',$exif['GPS']['GPSLongitude'][0]);
$degree = $degree_cal_1 / $degree_cal_2;

$minutes_cal_1 = before('/',$exif['GPS']['GPSLongitude'][1]);
$minutes_cal_2 = after('/',$exif['GPS']['GPSLongitude'][1]);
$minutes = $minutes_cal_1 / $minutes_cal_2;


$seconds_cal_1 = before('/',$exif['GPS']['GPSLongitude'][2]);
$seconds_cal_2 = after('/',$exif['GPS']['GPSLongitude'][2]);
$seconds = $seconds_cal_1 / $seconds_cal_2;

$longitude = $degree+($minutes/60)+($seconds/3600);
debug($longitude);
?>



