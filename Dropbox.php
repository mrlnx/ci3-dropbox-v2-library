<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* Name:  Dropbox Library
	*
	* Version: 1.0.0
	*
	* Author:	Marlon Lede
	*			marlonlede@gmail.com
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
	
	require_once 'dropbox/DropboxRequest.class.php';
	require_once 'dropbox/DropboxResponse.class.php';
	
	class Dropbox {
		
		protected $CI;
		
		private $host = 'https://api.dropboxapi.com/2/';
		private $namespacing; 
		private $endpoint;
		
		// api key
		private $bearer = '' // needed for use of this library;
		
		private static $okStatus = array(412);
		private $debug = false;
		
		/**
		 * 
		 * @function __construct
		 * @access public
		 * @return void
		 */
		
		public function __construct() {
			$this->CI =& get_instance();
		}
		
		/**
		 * 
		 * @function connectDropbox
		 * @access public
		 * @return void
		 * @params $namespacing
		 * @params $endpoint
		 * @params $data
		 */
		
		public function connectDropbox($namespacing = '', $endpoint = '', $data = null) {
			
			if($namespacing == '' && $endpoint == '' && $data != null) {
				return $this->api($namespacing, $endpoint, $data);
			}
		}
		
		/**
		 * 
		 * @function api
		 * @access private
		 * @return void
		 * @params 4namespacing
		 * @params $endpoint
		 * @params $data
		 */
		
		private function api($namespacing, $endpoint, $data = null) {
			
			$this->endpoint = $endpoint;
			$this->namespacing = $namespacing;
			
			$url = $this->host . $this->namespacing . $this->endpoint;
			
			$request = new DropboxRequest($url, $data, $this->bearer);
			
			$resp = $request->send();
			
			if (!in_array($resp->getStatusCode(), self::$okStatus)) {
				
				if($this->debug == true) {
					throw new Exception('DropboxDB-HTTP Error: '.$resp->getBody(), $resp->getStatusCode());
				}
			}
			
			$response = $resp->getBody();
			
			if ('application/json' == $resp->getContentType()) {
				$response = json_decode($response);
			}
			
			return $response;
		}
		
		/**
		 * Setter sets bearer; the bearer is the dropbox api key;
		 * @access public
		 * @return void
		 * @params $bearer 
		 **/
		 
		 
		 public function set_bearer($bearer) {
			$this->bearer = $bearer;
		 }
		
		/**
		 * 
		 * @function account_info
		 * @access public
		 * @return void
		 * @params $account_id
		 */
		
		public function account_info($account_id = null) {
			return $this->api('users', '/get_account', "{\"account_id\": \"" . $account_id . "\"}");
		}
		
		/**
		 * 
		 * @function create_folder
		 * @access public
		 * @return void
		 * @params $data
		 */
		 
		public function create_folder($data = null) {
			return $this->api('files', '/create_folder', $data);
		}
		
		/**
		 * 
		 * @function delete_folder
		 * @access public
		 * @return void
		 * @params $data
		 */
		 
		
		//delete
		public function delete_folder($data = null) {
			return $this->api('files', '/delete', $data);
		}
		
		/**
		 * 
		 * @function folder_member_list
		 * @access public
		 * @return void
		 * @params $data
		 */
		
		public function folder_member_list($data = null) {
			
			$shared_folder_id = $this->metadata($data)->shared_folder_id;
			return $this->api('sharing', '/list_folder_members', "{\"shared_folder_id\": \"" . $shared_folder_id . "\",\"actions\": [],\"limit\": 10}");
		}
		
		/**
		 * 
		 * @function share_holder
		 * @access public
		 * @return void
		 * @params $data
		 */
		
		public function share_folder($data = null) {
			return $this->api('sharing', '/share_folder', $data);
		}
		
		/**
		 * 
		 * @function folder_add_member
		 * @access public
		 * @return void
		 * @params $data
		 */
		
		public function folder_add_member($data = null) {
			return $this->api('sharing', '/add_folder_member', $data);
		}
		
		/**
		 * 
		 * @function folder_delete_member
		 * @access public
		 * @return void
		 * @params $data
		 */
		
		public function folder_delete_member($data = null) {
			return $this->api('sharing', '/remove_folder_member', $data);
		}
		
		/**
		 * 
		 * @function get_metadata
		 * @access private
		 * @return void
		 * @params $data
		 */
		
		public function metadata($data = null) {
			return $this->api('files', '/get_metadata', $data);
		}
	}
