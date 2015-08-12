<h1>Volunteers Create</h1>
<?php
include('../../bootstrap.php');

// Config
$data = array(
  'domain'  => 'netherlands'
);

$sample_user = array(
  'username' => 'didier' . time(),
  'email' => 'didier' . time() . '@barbelivien1.com',
  'firstname' => 'Didier',
  'lastname' => 'Barbelivien',
  'fullname' => 'Didier Barbelivien',
  'initials' => 'DB',
  'prefix' => 'Van',
  'suffix' => '',
  'gender' => 'male',
  'birth' => array(
    'place' => 'Nancy',
    'date' => '1980-03-10 01:00:00+01:00' // Date with timezone.
  ),
  'bio' => 'I am a popular singer among a certain category of aged people.',
  'locations' => array(
    array(
      'country' => 'France',
      'city' => 'Paris',
      'house_number'=> '12',
      'postcode' => '96000',
      'coordinates' => array(
        'latitude' => '52.695864',
        'longitude' => '5.202644'
      ),
      'streetname' => 'place de la police'
    )
  ),
  'contacts' => array(
    'phones' => array(
      'house' => '0382256054',
      'mobile' => '0676790609'
    ),
    'social' => array(
      'twitter' => 'twitterlogin',
      'facebook' => 'facebooklogin'
    )
  ),
  'languages' => array(
    'en-US' => 'primary',
    'nl' => 'secondary'
  ),
  'jobs' => array(
    'Driver',
    'IT Programmer'
  ),
  'diplomas' => 'PHD',
  'skills' => array(
    'general' => array(
      'Activist',
      'Organiser',
      'TEST'
    )
  ),
  'locale' => array(
    'timezone' => "Asia/Kolkata"
  ),
  'domains' => array(
    'int' => 1,
    'nl' => 2,
  ),
  'integrations' => array(
    array(
      "externalid" => "2011023243",
      "systemname" => "charibase"
    ),
    array(
      "externalid" => "2011023244",
      "systemname" => "mailchimp"
    )
  ),
  'privacy' => array(
    'hidephone' => 1,
    'hideavatar' => 1,
    'hidelastname' => 1
  )
);

$postdata = array(
  'domain' => 'netherlands',
  'volunteer' => $sample_user,
);

$url = '/private/volunteers.json?';

$s = new ggw_socket();
$result = $s->post($url,$data,$postdata,true);

echo '<p> POST ' . $s->uri . ' ('. $s->timer . ')</p>';

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
