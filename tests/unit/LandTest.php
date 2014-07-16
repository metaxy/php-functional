<?php
class LandTest extends PHPUnit_Framework_TestCase
{
	/**
	  * @dataProvider provider
	  */
	function test($x,$y,$e)
	{
		$this->assertSame(l_and($x,$y),$e);
	}

	/**
	  * @dataProvider provider
	  */
	function testCurry($x,$y,$e)
	{
		$f = l_and($y);
		$this->assertSame($f($x),$e);
	}

	function provider()
	{
		return 
		[
			[
				true,
				false,
				false,
			],
			[
				true,
				true,
				true
			],
			[
				false,
				false,
				false
			],
			[
				false,
				true,
				false
			]
		];
	}
}
