<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');

class ggw_socket {
	public $uri;
	public $error;
	public $result;

	/**
	 * REST GET
	 * @param $url string base url
	 * @param $data array parameters to be added in URL
	 * @param $auth string auth token
	 */
	public function get($url,$data,$auth=false) {
		$this->result = false;
		$this->curl_error = null;

		$this->uri = $url . http_build_query($data);

		if ($auth) {
			$this->uri = $this->uri . '&' . http_build_query(Config::auth());
		}
		$ch = curl_init($this->uri);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
		$headers = array(
			'Cache-Control: no-cache', 
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$this->result = curl_exec($ch);
		if($this->result  === false) {
			$this->curl_error =  curl_error($ch);
		}
		curl_close($ch);
		return $this->result;
	}
}
?>
