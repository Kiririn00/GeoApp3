<?php
const APPID = 'XOI8hrbwyqNwbkeIAR/l+08PIFSMrSIiBWUp281VoGQ';
$text = '彼はベンですか？いいえ彼はベンではありません。';
$to = 'en';
 
$ch = curl_init('https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate?Text=%27'.urlencode($text).'%27&To=%27'.$to.'%27');
curl_setopt($ch, CURLOPT_USERPWD, APPID.':'.APPID);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
$result = curl_exec($ch);
$result = explode('<d:Text m:type="Edm.String">', $result);
$result = explode('</d:Text>', $result[1]);
//debug($result);
$result = $result[0];
echo $text." -> ".$result;
?>