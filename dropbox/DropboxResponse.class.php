<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* Name:  DropboxResponse
	*
	* Version: 1.0.0
	*
	* Author: Marlon Lede
	*		  marlonlede@gmail.com
	*
	*
	* Location: public - https://github.com/mrlnx/dropbox/ci3-dorpbox-v2-api
	*
	* Created:  08-07-2016
	*
	* Description: Connection to Dropbox
	*
	* Requirements: PHP5 or above
	*
	*/

	class DropboxResponse {
		
		private $status_code = 200;
		private $content_type = '';
		private $body = '';
		
		/**
		 * Constructor
		 * @params $status_code
		 * @params $content_type
		 * @params $body
		 */
		
		public function __construct($status_code, $content_type, $body) {
			$this->status_code = $status_code;
			$this->content_type = $content_type;
			$this->body = $body;
		}
		
		/**
		 * @return $this->body
		 **/
		
		public function getBody() {
			return $this->body;
		}
		
		/**
		 * @return $this->status_code
		 **/
		
		public function getStatusCode() {
			return $this->status_code;
		}
		
		/**
		 * @return $this->content_type
		 **/
		
		public function getContentType() {
			return $this->content_type;
		}	
	}
