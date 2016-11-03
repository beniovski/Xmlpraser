<?php
set_time_limit(0);
require ('appLink.php');
require('array.php');
//require ('run.php');


interface Ixmlvalidation
{
	public function file_open($filename);   //  otwarcie pliku z obsÄąâ€šugĂ„â€¦ bÄąâ€šĂ„â„˘dÄ‚Ĺ‚w
	public function ftp_login($ftp_server,$ftp_username,$ftp_password); // logowanie do ftp 
	public function ftp_send($send_file); // wysyłanie przetworzonego pliku xml na ftp
	public function open_xml($xml_file); // otwarcie pliku xml
	public function create_data(); // tworzenie nowego pliku xml
	public function file_data_save($handle, $string); // zapis danych do nowego pliku xml

	
}


class XmlValidation implements Ixmlvalidation
{
	private   $ftp_server = "ftp.opole.nazwa.pl";
	private   $ftp_username   = "opole_xmfile";
	private   $ftp_password   = "seM%<gho]9YYceTN]nk7";	
	private   $file = 'http://skk.erecruiter.pl/OffersXml.ashx?cid=20132496';
	
	public $plik;
	public $xml_handle;
	public $conn_id;
	public $count;
	public $wsk;
	public $xml_data;
	
	
function __construct()
{
    $this->ftp_login($this->ftp_server, $this->ftp_username, $this->ftp_password);
    $this->open_xml($this->file);
    
}
	
function file_open($filename)
{
	$this->plik=fopen($filename,'w');
	
	if(!$this->plik)
	
	{
		echo "BLAD OTWARCIA PLIKU ";
		exit;
	}
	
}
	
function ftp_login($ftp_server,$ftp_username,$ftp_password)
	{
		$this->conn_id = @ftp_connect($ftp_server) or die("could not connect to $this->ftp_server");		
		
		if(!@ftp_login($this->conn_id, $ftp_username, $ftp_password))
		
		{
			echo "NIE MOZNA ZALOGOWAC SIE DO KONTA FTP";
			exit;
		}
		
	}
	
function ftp_send($send_file)
	
	{		
		
		if(!@ftp_put($this->conn_id,$send_file, $send_file, FTP_ASCII))
		
		{
			echo "Blad wyslania pliku na serwer";
			exit;
		}
		
		//ftp_close($this->conn_id);
		
	}
	
function open_xml($xml_file)
{
	
	$this->xml_handle = @simplexml_load_file($xml_file);  // ladowanie pliku xml
		
	if(!$this->xml_handle) 																											// sprawdzanie porpawnosci zaladowania pliku oraz w zaleznosci od wyniku wyswietlenie komunikatu
	
	{
		echo "PRZETWARZANIE PLIKU XML NIE POWIODÄąďż˝O SIĂ„ďż˝";
		exit;
	}
	
	
	$this->count = $this->xml_handle->count().'<br>';	   		// odczytanie iloÄ‚â€žĂ„â€¦Ä‚Ë�Ă˘â€šÂ¬ÄąĹşci obiektÄ‚â€žĂ˘â‚¬ĹˇĂ„Ä…Ă˘â‚¬Ĺˇw w pliku xml
	echo "aktualna ilosc ogloszen w bazie: ".$this->count;
	
	
}
	
function create_data()	
{	
	$i=0;
	$XmlDataArray=[];
	$link = new AppLink();	
	
	while($i<$this->count)
	
	{		
	
	$company_description = strip_tags($this->xml_handle->job[$i]->companyDescription);
	$location=$this->xml_handle->job[$i]->location;
	$name = $this->xml_handle->job[$i]->title;
	$country = $this->xml_handle->job[$i]->country;
	$countryRegionName = $this->xml_handle->job[$i]->countryRegionName;
	$position_description = $this->xml_handle->job[$i]->positionDescription;
	$requirements = $this->xml_handle->job[$i]->requirements;
	$opportunites =$this->xml_handle->job[$i] ->opportunites;
	$notes=$this->xml_handle->job[$i]->notes;
	$application_link=$this->xml_handle->job[$i]->applicationLink;
	$clause = strip_tags($this->xml_handle->job[$i]->clause);
	$data_start=$this->xml_handle->job[$i]->publishDate;
	$data_exp=$this->xml_handle->job[$i]->expiryDate;
	$jobid=$this->xml_handle->job[$i]->uniqueId;
	$location=$this->xml_handle->job[$i]->location;
	
	$a = $link->sql_query($name);
	$category = $link->CatAliasQuery($a['cat_id']);
	$GeneretedAppLink =$link->AppLinkGenerator($a,$category['alias']);
	
	$XmlDataArray[$i] = [ 	
							'company_description' => $company_description,
							'location' => $location,
							'name' => $name,
							'country' => $country,
							'CountryRegionName' => $countryRegionName,
							'position_description' => $position_description,
							'Requirements' => $requirements,
							'opportunites' => $opportunites,
							'notes' => $notes,
							'application_link' => $application_link,
							'clause' => $clause,
							'$data_start' => $data_start,
							'data_exp' => $data_exp,
							'jobid' => $jobid,
							'location' => $location,
							'GeneretedAppLink' => $GeneretedAppLink,
							
						];
	$i++;
			
	}	
	
	return $XmlDataArray;
}

function file_data_save($handle, $string)
{
	$save= fwrite($handle, $string);
	
	if($save)
	{
		echo"zapisano poprawnie dane do pliku";
	}
	else 
	{
		echo"błąd zapisu do pliku ";
	}
	
}	

}


$xmlValid = new XmlValidation();












































