<h1>Groups view</h1>
<?php
include('../../bootstrap.php');

// Config
$data = array(
    "domain" => "netherlands",
    "limit" => 1
);
$url = '/public/groups/324e1602-3673-4d52-93ee-eadf94cbea67.json?'; // netherlands main

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
