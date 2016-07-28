<?php

namespace App\Libraries\ExternalService;

class ExternalResponse {
	private $status;
	private $header;
	private $content;
	private $exception;
	public function __construct($status, $header, $content, $exception = null) {
		if ($exception !== null) {
			$status = 500;
			$this->exception = $exception;
		}
		
		$this->status = $status;
		$this->header = $header;
		$this->content = $content;
		$this->exception = $exception;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 *
	 * @param unknown_type $status        	
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	public function getHeader() {
		return $this->header;
	}
	
	/**
	 *
	 * @param unknown_type $header        	
	 */
	public function setHeader($header) {
		$this->header = $header;
	}
	
	/**
	 *
	 * @return the unknown_type
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 *
	 * @param unknown_type $content        	
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 *
	 * @param unknown_type $exception        	
	 */
	public function setException($exception) {
		$this->exception = $exception;
	}
	
	/**
	 *
	 * @return $exception is null
	 */
	public function hasError() {
		return ($this->exception == null);
	}
}