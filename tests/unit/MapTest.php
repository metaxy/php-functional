<?php
class MapTest extends PHPUnit_Framework_TestCase
{
	/**
	  * @dataProvider provider
	  */
	function test($d,$func,$e)
	{
		$this->assertSame(map($func,$d), $e);
	}

	/**
	  * @dataProvider provider
	  */
	function testCurry($d,$func,$e)
	{
		$f = map($func);
		$this->assertSame($f($d), map($func,$d));
		$this->assertSame($f($d),$e);
	}

	function provider()
	{
		return 
			[
				[
					[1,2,3,4],
					id(),
					[1,2,3,4]
				],
				[
					[],
					id(),
					[]
				],
				[
					[1,2,3,4],
					plus(1),
					[2,3,4,5]
				],
				[
					[],
					plus(1),
					[]
				]
		];
	}
}
