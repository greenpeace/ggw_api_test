<h1>Volunteers Index</h1>
<?php
include('../../bootstrap.php');

// Config
$data = array(
	"domain" => "netherlands",
	"must_have_default_avatar" => "0",
	"limit" => 1
);
$url = '/public/volunteers.json?';

$s = new ggw_socket();
$result = $s->get($url,$data);

echo '<p> GET ' . $s->uri . ' ('. $s->timer . ')</p>';

// Results
if($result === false){
	echo 'Curl error: ' . $s->curl_error;
} else {
	$json_string = json_decode($result);
	echo '<pre>';
	print_r($json_string);
	echo '</pre>';
}
?>
