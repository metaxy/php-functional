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
// foldr :: (a -> b -> b) -> b -> [a] -> b
function foldr()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 3) {
		return array_reduce($args[2],$args[0],$args[1]);
	} else if($n == 2) {
		return function ($array) use ($args) {
			return array_reduce($array, $args[0], $args[1]);
		};
	} else if($n == 1) {
		return function ($init,$array) use($args) {
			return array_reduce($array,$args[0],$init);
		};
	} else if ($n == 0) {
		return function ($func,$init,$array) use ($args) {
			return array_reduce($array,$func,$init);
		};
	}
}

// map :: (a -> b) -> [a] -> [b]
function map()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 2) {
		return array_map($args[0], $args[1]);
	} else if ($n == 1) {
		return function ($x) use ($args) {
			return array_map($args[0],$x);
		};
	} else if($n == 0) {
		return function ($x,$y) {
			return array_map($x,$y);
		};
	}
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
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 2) {
		return array_merge($args[0], $args[1]);
	} else if ($n == 1) {
		return function ($x) use ($args) {
			return array_merge($args[0],$x);
		};
	} else if($n == 0) {
		return function ($x,$y) {
			return array_merge($x,$y);
		};
	}
}

function edot()
{
	$n = func_num_args();
	$res = null;
	for($i=0; $i<$n;$i++) {
		//$res = 
	}
}

function dot()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 3) {
		return $args[0]($args[1]($args[2]));
	} else if($n == 2) {
		return function ($x) use ($args) {
			return $args[0]($args[1]($x));
		};
	} else if($n == 1) {
		return function ($x,$y) use($args) {
			return $args[0]($y($x));
		};
	} else if ($n == 0) {
		return function ($x,$y,$z) use ($args) {
			return $x($y($z));
		};
	} 
}
function test($x)
{
	return $x*2;
}
function plus()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 2) {
		return $args[0] + $args[1];
	} else if ($n == 1) {
		return function ($x) use ($args) {
			return $args[0] + $x;
		};
	} else if($n == 0) {
		return function ($x,$y) {
			return $x + $y;
		};
	}
}
function id()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if ($n == 1) {
		return $args[0];
	} else if($n == 0) {
		return function ($x) {
			return $x;
		};
	}

}
function attr()
{
	$n = func_num_args();
	$args = func_get_args(); 
	if($n == 2) {
		$class = $args[1];
		$at = $args[0];
		return $class->$at;
	} else if ($n == 1) {
		return function ($x) use ($args) {
			$at = $args[0];
			return $x->$at;
		};
	} else if($n == 0) {
		return function ($x,$y) {
			return $y->$x;
		};
	}
}
/*$test = dot(
	map(plus(2)),
	map(plus(1)),
	[1,2,3]
);
 */
//$func = dot(merge([3]),map(plus(1)));

//die(print_r($func([1,2])));

