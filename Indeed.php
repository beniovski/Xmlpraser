<?php

Class IndeedValidation 
{
	
	
	private $indeed_head = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<source>
								<publisher>www.paretti.pl</publisher>
								<publisherurl>www.paretti.pl</publisherurl>
								<lastBuildDate></lastBuildDate>';
	
	private $indeed_cont="<job>
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
	
	private $indeed_bottom = "</source>";
		
    public $data = "";
		
	function __construct($xmlData = array(), XmlValidation $validation)
	{
		$validation->file_open("indeed.xml");
		$this->indeedCreation($xmlData);
		$validation->file_data_save($validation->plik, $this->data);
		//$validation->ftp_send("indeed.xml");		
	}
	
	
	function indeedCreation($xmlData =array())
	{
		
		$this->data .= $this->indeed_head;
				
		foreach ($xmlData as $key => $offer  )
		
		{
			foreach ($offer as $key=> $value)
			{
				$this->data .= sprintf($this->indeed_cont, 
						$offer['name'] ,
						$offer['data_start'],
						$offer['jobid'],
						$offer['application_link'],
						$offer['location'],
						$offer['CountryRegionName'],
						$offer['country'], 
						$offer['position_description'], 
						$offer['Requirements'], 
						$offer['opportunites']);
			}		
			
		}
		
		$this->data.=$this->indeed_bottom;		
	}
	
	
	
	
	
}