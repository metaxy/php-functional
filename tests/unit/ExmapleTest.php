<?php
class ExampleTest extends PHPUnit_Framework_TestCase
{
	/**
	  * @dataProvider provider
	  */
	function test($d,$func,$e)
	{
		$this->assertSame(true,true);
	}

	/**
	  * @dataProvider provider
	  */
	function testCurry($d,$func,$e)
	{
		$this->assertSame(true,true);
	}

	function provider()
	{
		return 
		[
			[1,2,3]
		];
	}
}
