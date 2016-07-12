<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* Name:  DropboxRequest
	*
	* Version: 1.0.0
	*
	* Author: Marlon Lede
	*		  marlonlede@gmail.com
	*
	*
	* Location: public - https://github.com/mrlnx/dropbox/ci3-dorpbox-c2-api
	*
	* Created:  08-07-2016
	*
	* Description: Connection to Dropbox
	*
	* Requirements: PHP5 or above
	*
	*/
	
	class DropboxRequest {
		
		private $url = "";
		private $data = null;
		private $headers = array();

		/**
		* Create a DropboxRequest
		*
		* @throws Exception if invalid method is passed
		*
		* @param string $url
		* @param string $data
		* @param string $bearer
		*/
		 
		public function __construct($url, $data = null, $bearer = null)
		{
			$this->url = $url;
			$this->data = $data;
			
			if (null !== $this->data)
			{
				$this->headers['Content-Type'] = 'application/json';
			}

			if (null !== $this->data && null != $bearer)
			{
				$this->headers['Authorization'] = 'Bearer ' . $bearer;
			}
		}
		
		/**
		 * Send request via CURL
		 *
		 * @return DropboxResponse
		 */
		 
		public function send()
		{
			$headers = array();
			
			foreach ($this->headers as $key => $value) {
				$headers[] = $key.': '.$value;
			}
			
			$curl = curl_init($this->url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
			
			$body = curl_exec($curl);
			$info = curl_getinfo($curl);
			
			$response = new DropboxResponse($info['http_code'], $info['content_type'], $body);
			
			curl_close($curl);
			
			return $response;
		}
	}

