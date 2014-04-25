<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');

class ggw_socket {
	public $uri;
	public $error;
	public $result;
	public $curl;
	public $timer;

	/**
	 * REST GET
	 * @param $url string base url
	 * @param $data array parameters to be added in URL
	 * @param $auth string auth token
	 */
	public function get($url,$data,$api_auth=false) {
		$this->result = false;
		$this->curl_error = null;
		$headers = array(
			'Cache-Control: no-cache'
		);

		$this->uri = Config::$environment . $url . http_build_query($data);

		// Api and http auth
		if ($api_auth) {
			$this->uri = $this->uri . '&' . http_build_query(Config::api_auth());
		}
		$this->curl = curl_init($this->uri);

		if (Config::$http_auth) {
			$this->setHttpAuth($this->curl);
		}

		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
		
		$this->timer_start();
		$this->result = curl_exec($this->curl);
		$this->timer_end();

		if($this->result === false) {
			$this->curl_error =  curl_error($this->curl);
		}
		curl_close($this->curl);
		return $this->result;

	}

  /**
   * REST POST
   * @param $url string base url
   * @param $data array parameters to be added in URL
   * @param $postdata the data to be posted
   * @param $auth string auth token
   */
  public function post($url,$data, $postdata, $api_auth=false) {
    $this->result = false;
    $this->curl_error = null;
    $headers = array(
      'Cache-Control: no-cache'
    );

    $this->uri = Config::$environment . $url . http_build_query($data);

    // Api and http auth
    if ($api_auth) {
      $this->uri = $this->uri . '&' . http_build_query(Config::api_auth());
    }
    $this->curl = curl_init($this->uri);
    curl_setopt($this->curl, CURLOPT_POST, 1);
    curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

    if (Config::$http_auth) {
      $this->setHttpAuth($this->curl);
    }

    $this->timer_start();
    $this->result = curl_exec($this->curl);
    $this->timer_end();

    if($this->result === false) {
      $this->curl_error =  curl_error($this->curl);
    }
    curl_close($this->curl);
    return $this->result;
  }


	/**
	 * REST GET
	 * @param $url string base url
	 * @param $data array parameters to be added in URL
	 * @param $auth string auth token
	 */
	private function setHttpAuth() {
		if($this->curl != null) {
			curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($this->curl, CURLOPT_USERPWD, Config::http_auth()); 
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);                          
			curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);                           
			curl_setopt($this->curl, CURLOPT_USERAGENT, 'GGW API TEST');
			curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
		}
	}

	public function timer_start() {
		$this->timer = microtime(true);
	}

	public function timer_end() {
		$this->timer = microtime(true) - $this->timer;
	}
}
?>
