<?php
//http://ip-api.com/xml

$opts = array('http'=> array('proxy'=> 'tcp://www.cache:3128', 'request_fulluri'=>True));
$context = stream_context_create($opts);

$xmltxt = file_get_contents('http://ip-api.com/xml', false, $context);

//Chargement du source XML 
$xml = new DOMDocument;
//$xml->load('gps.xml');
$xml->loadXML($xmltxt);

$xsl = new DOMDocument;
$xsl->load('bicyclette.xsl');

// Configuration du transformateur
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attachement des règles xsl 

echo $proc->transformToXML($xml);