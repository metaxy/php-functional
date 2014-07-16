<?php
use Dydro\Benchmark\Benchmark;
use Dydro\Benchmark\Manager;

require_once(__DIR__ . '/../../vendor/autoload.php');
include 'common.php';

function run($times, $length) {
	$a = new Benchmark('Functional Map x'.$times);
	$a1 = new Benchmark('Functional Map(w\o plus) my_map x'.$times);
	$a2 = new Benchmark('Functional Map(w\o plus) array_map x'.$times);
	$b = new Benchmark('array_map x'.$times);
	$c = new Benchmark('nromal map x'.$times);
	$manager = new Manager();
	$manager->addBenchmarks([$a, $a1,$a2, $b, $c]);

	$data = [];
	for($i = 0; $i < $length; $i++) {
		$data[] = $i*2+1;
	}

	$a->start();
	$plus = plus(1);
	for($i = 0; $i < $times; $i++) {
		$res = map($plus,$data);
	}
	$a->stop();
	
	$a1->start();
	for($i = 0; $i < $times; $i++) {
		$res = map2(function($x){return $x+1;}, $data);
	}
	$a1->stop();

	$a2->start();
	for($i = 0; $i < $times; $i++) {
		$res = map(function($x){return $x+1;}, $data);
	}
	$a2->stop();
	

	$b->start();
	$func = function($x){return $x+1;};
	for($i = 0; $i < $times; $i++) {
		$res = array_map($func,$data);
	}
	$b->stop();
	
	$c->start();
	$func = function($x){return $x+1;};
	for($i = 0; $i < $times; $i++) {
		$res = [];
		foreach($data as $i) {
			$res[] = $func($i);
		}
	}
	$c->stop();
	echo $manager->getResults('Test Array len ='.$length);
}

run(20,1000);


