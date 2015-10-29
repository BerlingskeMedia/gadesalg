<?php

class Url
{
	public $url;
	public $callback;
	public $requiresLogin;

	public function Url($url, $callback, $reqlogin = true)
	{
		$this->url = $url;
		$this->callback = $callback;
		$this->requiresLogin = $reqlogin;
	}
	
	public function setUrl($url)
	{
		$this->url = $url;
	}
	
	public function getUrl()
	{
		return $this->url;
	}

	public function setCallback($funcname)
	{
		$this->callback = $funcname;
	}
	
	public function getCallback()
	{
		return $this->callback;
	}
}

