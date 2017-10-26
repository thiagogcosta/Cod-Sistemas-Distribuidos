<?php 

	function add($a, $b){
		return $a + $b;
	}

	function sub($a, $b){
		return $a - $b;
	}

	function div($a, $b){
		return $a / $b;
	}

	function mult($a, $b){
		return $a * $b;
	}

$arg = array('uri' => 'http://jemiaymen.com');

//soap without wsdl must have uri

$server = new SoapServer(null, $arg);
$server->addFunction('add');
$server->addFunction('sub');
$server->addFunction('div');
$server->addFunction('mult');

$server->handle();

?>