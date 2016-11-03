<?php



//*********************************************************************SZABLON XML NA PRACA**********************************************************************************

$pracapl_head= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
						<jobs>
					  <transfer kod="'.date('l jS F Y h:i:s A').'">';
					  
$pracapl_cont='<job action="D">

								<industry>4</industry>
								<company_name><![CDATA[{Company name]]></company_name>
								<email><![CDATA[opole@paretti.pl]]></email>
								<title><![CDATA[%s]]></title>
								<nr_ref><![CDATA[numer referencyjny]]></nr_ref>
								<country>163</country>
								<province>
								</province>
								<province>
								<province_id>1</province_id>
								<province_id>7</province_id>
								<city><![CDATA[%s]]></city>
								</province>
								<description><![CDATA[%s]]></description>
								<requirements><![CDATA[%s]]></requirements>
								<benefits><![CDATA[%s]]></benefits>
								<form_of_contact><![CDATA[Form of contact]]></form_of_contact>
								<firm_information><![CDATA[Informacje about the company]]></firm_information>
								<salary_min>100</salary_min>
								<salary_max>200</salary_max>
								<template>1</template>
								<week_job on="1" validFrom="2011-05-06 10:00:00"validTo="2011-05-13 09:59:59" />
								<super_job>1</super_job>
								</job>';	
								
$pracapl_bottom='</transfer></jobs>';

//*************************************************************************************************************************************************************************

//**************************************************************SZABLON XML NA CAREERJET*************************************************************************************

$careerjet_head='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
					  <jobs>';
					  
$careerjet_cont="<job>
								<title><![CDATA[%s]]></title>
								<url><![CDATA[www.paretti.pl]]></url>
								<location><![CDATA[%s]]></location>
								<company><![CDATA[PARETTI]]></company>
								<company_url><![CDATA[http://www.paretti.pl/]]></company_url>
								<description><![CDATA[%s.%s.%s]]>
								</description>
								<contracttype><![CDATA[]]></contracttype>
								<salary><![CDATA[]]></salary>
								<contact>
									<name><![CDATA[PARETTI]]></name>
									<email><![CDATA[opole@paretti.pl]]></email>
									<phone><![CDATA[+ 48 544 99 99 ]]></phone>
								</contact>
								<apply_url><![CDATA[%s]]></apply_url>
						</job>";
						
$carrerjet_bottom='</jobs>';

//*************************************************************************************************************************************************************************
//**************************************************************SZABLON XML NA CAREERJET*************************************************************************************


$indeed_head = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<source>
								<publisher>www.paretti.pl</publisher>
								<publisherurl>www.paretti.pl</publisherurl>
								<lastBuildDate>'.date('l jS F Y h:i:s A').'</lastBuildDate>';

$indeed_cont="<job>
										<title><![CDATA[%s]]></title>
										<date><![CDATA[%s]]></date>
										<referencenumber><![CDATA[%s]]></referencenumber>
										<url><![CDATA[%s]]></url>
										<company><![CDATA[]]></company>
										<city><![CDATA[%s]]></city>
										<state><![CDATA[%s]]></state>
										<country><![CDATA[%s]]></country>
										<postalcode><![CDATA[]]></postalcode>
										<description><![CDATA[%s.%s.%s]]></description>
										
						</job>";
						
$indeed_bottom = "</source>";

  
$tablica =  array  ( 
							 array('indeed.xml', 'pracapl.xml','carrerjet.xml' , 'goldenline'),
							 array($indeed_head, $pracapl_head, $careerjet_head,''),
							 array($indeed_cont, $pracapl_cont, $careerjet_cont, ''),
							 array($indeed_bottom, $pracapl_bottom, $carrerjet_bottom, ''),						
							
						
						);
						
	
						
						

?>						