<?php

namespace App\Page;

class Column
{
	private $content;
	private $size;

	public function __construct(Array $args = [])
	{
		$this->content = null;
		$this->size = array_key_exists('size', $args) ? $args['size'] : null;
	}

	public function setContent(String $content)
	{
		$this->content = $content;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function clear()
	{
		$this->content = null;
	}
}
?>