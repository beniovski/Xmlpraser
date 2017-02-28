<?php

require_once 'XmlValidator.php';
require_once 'Indeed.php';
require_once 'Carierjet.php';



$Xml = new XmlValidation();
$data = array();
$data = $Xml->create_data();
$indeed = new IndeedValidation($data, $Xml);
$carrerjet = new CarierjetValidation($data, $Xml);

