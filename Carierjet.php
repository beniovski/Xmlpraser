<?php


Class CarierjetValidation 
{
	
	private $careerjet_head='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
					  <jobs>';
		
	private $careerjet_cont="<job>
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
	
	private $carrerjet_bottom='</jobs>';
	
	
	public  $data = "";
	
	function __construct($xmlData =array(),XmlValidation $validation)
	{
		$validation->file_open("careerjet.xml");
		$this->careerJetCreation($xmlData);
		$validation->file_data_save($validation->plik, $this->data);
		$validation->ftp_send("careerjet.xml");
	}
	
	function careerJetCreation($xmlData =array())
	{
		$this->data = $this->careerjet_head;
		foreach ($xmlData as $key => $offer  )
	
		{
			foreach ($offer as $key=> $value)
			{
				$this->data .= sprintf($this->careerjet_cont,
						$offer['name'],
						$offer['location'],
						$offer['position_description'], 
						$offer['Requirements'], 
						$offer['opportunites'],
						$offer['application_link']);
			}
		}
		$this->data.=$this->carrerjet_bottom;
	}	
	
	
}