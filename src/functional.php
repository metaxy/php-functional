<?php
//namespace f;
function curryl($callable)
{
    $outerArguments = func_get_args();
    array_shift($outerArguments);
 
    return function() use ($callable, $outerArguments) {
        return call_user_func_array($callable, array_merge($outerArguments, func_get_args()));
    };
}
 
function curryr($callable)
{
    $outerArguments = func_get_args();
    array_shift($outerArguments);
 
    return function() use ($callable, $outerArguments) {
        return call_user_func_array($callable, array_merge(func_get_args(), $outerArguments));
    };
}
function curry3($func, $args)
{
	$n = count($args);
	if($n == 3) {
		return $func($args[0], $args[1], $args[2]);
	} else if ($n == 2) {
		return function ($x) use ($func, $args) {
			return $func($args[0],$args[1],$x);
		};
	} else if ($n == 1) {
		return function ($x) use ($func, $args) {
			return $func($args[0],$x);
		};
	} else if($n == 0) {
		return function ($x,$y) use($func){
			return $func($x,$y);
		};
	}
}

function curry2($func, $args)
{
	$n = count($args);
	if($n == 2) {
		return $func($args[0], $args[1]);
	} else if ($n == 1) {
		return function ($x) use ($func, $args) {
			return $func($args[0],$x);
		};
	} else if($n == 0) {
		return function ($x,$y) use($func){
			return $func($x,$y);
		};
	}
}
function curry1($func, $args)
{
	$n = count($args);
	if($n == 1) {
		return $func($args[0]);
	} else if($n == 0) {
		return function ($x) use($func){
			return $func($x);
		};
	}
}
// foldr :: (a -> b -> b) -> b -> [a] -> b
function foldr()
{
	return curry3(
		function($func,$init,$array) {return array_reduce($array,$func,$init);},
		func_get_args()
	);
}

// map :: (a -> b) -> [a] -> [b]
function map()
{
	return curry2(
		function($x,$y) {return array_map($x,$y);}, 
		func_get_args());
}




/*
//reverse :: [a] -> [a]
function reverse($x)
{
	return array_reverse($x);
}
*/

//concat :: [[a]] -> [a]
//accepts a list of lists and concatenates them
function concat($x)
{
	return foldr(merge(), [],$x);
}

//(++) :: [a] -> [a] -> [a]
function merge()
{	
	return curry2(
		function ($x,$y) {
			return array_merge($x,$y);
		},
		func_get_args()
	);
}

function edot()
{
}

function dot()
{
	return curry3(
		function ($x,$y,$z) {
			return $x($y($z));
		},
		func_get_args()
	);
	

}
function test($x)
{
	return $x*2;
}
function plus()
{
	return curry2(
		function ($x,$y) {
			return $x + $y;
		},
		func_get_args()
	);
}
function id()
{
	return curry1(
		function ($x) {
			return $x;
		},
		func_get_args()
	);

}
function attr()
{
	return curry2(
		function ($x,$y) {
			return $y->$x;
		},
		func_get_args()
	);
}

function method()
{
	return curry2(
		function ($x,$y) {
			return $y->$x();
		},
		func_get_args()
	);
}

function methodArgs()
{
	return curry2(
		function ($z,$x,$y) {
			return $y->$x($z);
		},
		func_get_args()
	);
}
function l_and()
{
	return curry2(
		function ($x,$y) {
			return $x && $y;
		},
		func_get_args()
	);
}
function l_or()
{
	return curry2(
		function ($x,$y) {
			return $x || $y;
		},
		func_get_args()
	);
}

function f_and()
{
	return curry1(
		function ($x) {
			return foldr(l_and(),true,$x);
		},
		func_get_args()
	);
}
function f_or()
{
	return curry1(
		function ($x) {
			return foldr(l_or(),false,$x);
		},
		func_get_args()
	);
}
function all()
{
	return curry2(
		function($p,$list) {
			return dot(f_and(), map($p), $list);
		},
		func_get_args()
	);
}
function any()
{
	return curry2(
		function($p,$list) {
			return dot(f_or(), map($p), $list);
		},
		func_get_args()
	);
}
