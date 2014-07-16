<?php
class FandTest extends PHPUnit_Framework_TestCase
{
	/**
	  * @dataProvider provider
	  */
	function test($d,$e)
	{
		$this->assertSame(f_and($d),$e);
	}

	/**
	  * @dataProvider provider
	  */
	function testCurry($d,$e)
	{
		$f = f_and();
		$this->assertSame($f($d),$e);
	}

	function provider()
	{
		return 
		[
			[
				[true,true,true],
				true
			],
			[
				[true,true,false],
				false
			]
		];
	}
}
