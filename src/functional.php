<?php
//namespace f;

/*
 * php 5.6
function curry($func,$n, ...$args)
{
	if($n == count($args)) {
		return $func(...$args);
	} else {
		return function (...$a) use ($func, $args)
		{
			return $func(...$args,...$a);
		}
	}
}
 */

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
		function($func, $init, $array) {return array_reduce($array, $func, $init);},
		func_get_args()
	);
}

// map :: (a -> b) -> [a] -> [b]
function map()
{
	return curry2(
		function($x, $y) {
			return array_map($x, $y);
		}, 
		func_get_args());
}


//(++) :: [a] -> [a] -> [a]
function merge()
{	
	return curry2(
		function ($x, $y) {
			return array_merge($x, $y);
		},
		func_get_args()
	);
}
//concat :: [[a]] -> [a]
//accepts a list of lists and concatenates them
function concat($x)
{
	return foldr(merge(), [], $x);
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
// OPERATIONS ON BASIC TYPES
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

function prepend()
{
	return curry2(
		function ($x,$y) {
			return $x . $y;
		},
		func_get_args()
	);
}

function append()
{
	return curry2(
		function ($x,$y) {
			return $y . $x;
		},
		func_get_args()
	);
}

function startsWith()
{
	return curry2(
        function ($needle,$haystack) {
            return (substr($haystack, 0, strlen($needle)) === $needle);
		},
		func_get_args()
	);
}

function endsWith()
{
	return curry2(
        function ($needle,$haystack) {
            return substr($haystack, -strlen($needle))===$needle;
		},
		func_get_args()
	);
}
function contains()
{
	return curry2(
        function ($needle,$haystack) {
            return strpos($haystack, $needle) !== false;
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
// OBJECT OPERATIONS
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
// LOGIC OPERATION
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
		function($p, $list) {
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

function f_is_enum()
{
    return curry2(
        function($enumClass, $value) {
            return in_array($value, $enumClass::getValidValues());
        },
        func_get_args()
    );
}

function f_is_string()
{
    return curry1(
        function($value) {
            return is_string($value);
        },
        func_get_args()
    );
}


function f_is_array()
{
    return curry1(
        function($value) {
            return is_array($value);
        },
        func_get_args()
    );
}

function f_is_bool()
{
    return curry1(
        function($value) {
            return is_bool($value);
        },
        func_get_args()
    );
}
function f_is_int()
{
    return curry1(
        function($value) {
            return is_int($value);
        },
        func_get_args()
    );
}

function all_are()
{
    return curry2(
        function($p, $list) {
            return is_array($list) && dot(f_and(), map($p), $list);
        },
        func_get_args()
    );
}