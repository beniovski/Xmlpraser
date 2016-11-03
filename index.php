<?php
set_time_limit(0);
require ('appLink.php');
require('array.php');
require ('run.php');


interface Ixmlvalidation
{
	public function file_open($filename);   //  otwarcie pliku z obsĹ‚ugÄ… bĹ‚Ä™dĂłw
	public function ftp_login($ftp_server,$ftp_username,$ftp_password); // logowanie do ftp 
	public function ftp_send($send_file); // wysyĹ‚anie przetworzonego pliku xml na ftp
	public function open_xml($xml_file); // otwarcie pliku xml
	public function create_data($xml_content,$file); // tworzenie nowego pliku xml
	public function file_data_save($handle, $string); // zapis danych do nowego pliku xml

	
}


class XmlValidation extends OfapiClient implements Ixmlvalidation
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
		echo "PRZETWARZANIE PLIKU XML NIE POWIODĹ�O SIÄ�";
		exit;
	}
	
	
	$this->count = $this->xml_handle->count().'<br>';	   		// odczytanie iloĂ„Ä…Ă˘â‚¬Ĺźci obiektĂ„â€šÄąâ€šw w pliku xml
	echo "aktualna ilosc ogloszen w bazie: ".$this->count;
	
	
}
	
function create_data($xml_content,$file)	
{	
	$i=0;
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
	$application_link=$link->AppLinkGenerator($a,$category['alias']);	
	
	echo $application_link.'<br>';
	

	
	
	
	switch($file)
	{
		case "indeed.xml":
			$this->xml_data.=sprintf($xml_content,$name,$data_start,$jobid,$application_link,$location,$countryRegionName,$country, $position_description, $requirements, $opportunites);
			break;
			
		case "pracapl.xml":
			///echo "praca.pl";
			break;
			
		case 'carrerjet.xml':
			$this->xml_data.=sprintf($xml_content,$name,$location,$position_description, $requirements, $opportunites,$application_link);
			break;
		
		case 'goldenline':	
			
			$offer_data = [
					'native_id' => '31415926535',
					'start_date' => (new DateTime())->format('Y-m-d'),
					'exp_date' => (new DateTime())->add(new DateInterval('P35D'))->format('Y-m-d'),
					'company' => 'Test company',
					'position' => 'Test position',
					'refnum' => '123/45',
					'contact_email' => 'apply@example.com',
					'city' => 'Test city',
					'regions' => [$regions[0]['id']],
					'branches' => [$branches[0]['id'], $branches[1]['id']],
					'html_body' => 'Put entire contents of BODY tag here', ];
			break;
	}
	
		
	
	
	$i++;
	}
		
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

$j=0;
	
for($j; $j<4; $j++)

{
	$i=0;	

	$xmlValid -> file_open($tablica[$i][$j]);
	
	$xmlValid -> file_data_save($xmlValid->plik, $tablica[$i+1][$j]);

	$xmlValid -> create_data($tablica[$i+2][$j],$tablica[$i][$j]);

	$xmlValid -> file_data_save($xmlValid->plik, $xmlValid->xml_data);

	$xmlValid -> file_data_save($xmlValid->plik, $tablica[$i+3][$j]);

	$xmlValid -> ftp_send($tablica[$i][$j]);
	
	

}










































