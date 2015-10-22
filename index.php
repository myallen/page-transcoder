<?php

function autoloader($class) {
	include('./'.strtolower($class).'.php');
}
spl_autoload_register('autoloader');

$source = $argv[1];

$parser = new Parser($source);
$tags = $parser->doMagic();
//var_dump($tags);exit;

$assembler = new Assembler($tags);
echo $assembler->doMagic();

