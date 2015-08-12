<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class ggw_socket {
	public $uri;
	public $error;
	public $result;
	public $headers;
	public $curl;
	public $timer;

	/**
	 * REST GET
	 * @param $url string base url
	 * @param $data array parameters to be added in URL
	 * @param $auth string auth token
	 */
	public function get($url,$data=null,$api_auth=false) {
		$this->result = false;
		$this->curl_error = null;

		$this->uri = Config::$environment . $url;
		if(isset($data)) {
			$this->uri .= http_build_query($data);
		}

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
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Cache-Control: no-cache','Expect:'));
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, FALSE); // needed for tests on staging
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
		curl_setopt($this->curl, CURLOPT_HEADER, 1);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Expect:'));

		$this->timer_start();
		$response = curl_exec($this->curl);
		$this->timer_end();

		if($response === false) {
			$this->curl_error =  curl_error($this->curl);
		}

		$header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$this->headers = $this->_get_headers_from_curl_response($header);
		$this->result = substr($response, $header_size);

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


	/**
	 * Parse headers from curl response into associative array
	 * @param $response
	 * @return array
	 */
	protected function _get_headers_from_curl_response($response) {
		$headers = array();
		$header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

		foreach (explode("\r\n", $header_text) as $i => $line)
			if ($i === 0) {
				$headers['http_code'] = $line;
			} else {
				list ($key, $value) = explode(': ', $line);
				$headers[$key] = $value;
			}

		return $headers;
	}

}

// utility
function pr($r) {
	echo '<pre>';
	print_r($r);
	echo '</pre>';

}
