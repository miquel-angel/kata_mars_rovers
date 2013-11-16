<?php 
include 'mars.php';

class marsTest extends PHPUnit_Framework_TestCase
{
	private $obj;
	
	public function setUp()
	{
		$this->obj = new Mars();
	}

}

