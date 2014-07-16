<?php
class AllTest extends PHPUnit_Framework_TestCase
{
	/**
	  * @dataProvider provider
	  */
	function test($d,$func,$e)
	{
		$this->assertSame(all($func, $d), $e);
	}

	/**
	  * @dataProvider provider
	  */
	function testCurry($d,$func,$e)
	{
		$f = all($func);
		$this->assertSame($f($d),$e);
	}

	function provider()
	{
		return 
		[
			[
				[True,True,True],
				function($x){return $x == true;},
				True
			],
			[
				[True,True,False],
				function($x){return $x == true;},
				False
			],
			[
				[2,4,6,8],
				function($x){return $x % 2 == 0;},
				true
			]
		];
	}
}
