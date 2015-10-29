<?php
class Template
{
	public $content = "";
	public $filename;
	
	public function Template()
	{
	}
	
	public function load($filename)
	{
		$this->filename = $filename;
		$this->content = file_get_contents($filename);
	}

	public function replace($token, $content)
	{
		$this->content = str_replace($token, $content, $this->content);
	}
	
	public function getContent()
	{
		return $this->content;
	}

}

