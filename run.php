<?php

use GuzzleHttp\Client;

mb_internal_encoding('UTF-8');
require 'vendor/autoload.php';
require 'client.php';
require 'XmlValidator.php';


define('APP_KEY', '2f7ea8a7782923927322122292e10017');
define('SECRET_KEY', 'cb8c3125364aff93ecb19b371f9abd69');
define('HASH_KEY', '57737f45c02431689af0df6ad8ec4052');

$client = new OfapiClient(APP_KEY, SECRET_KEY, HASH_KEY);
$branches = $client->branches();
$regions = $client->regions();

echo '<br>';

$xmlValidation = new XmlValidation();

$offer_data = [
    'native_id' => '2342342342',
    'start_date' => (new DateTime())->format('Y-m-d'),
    'exp_date' => (new DateTime())->add(new DateInterval('P35D'))->format('Y-m-d'),
    'company' => 'Test company',
    'position' => 'Test position',
    'refnum' => '123/45',
    'contact_email' => 'apply@example.com',
    'city' => 'Test city',
    'regions' => [$regions[0]['id']],
    'branches' => [$branches[0]['id'], $branches[1]['id']],
    'html_body' => 'Put entire contents of BODY tag here',
];

//print_r($client->edit_offer($offer_data));
echo '<br>';
//print_r($client->offer_status($offer_data['native_id']));
echo '<br>';
//print_r($client->offer_statistics($offer_data['native_id']));

function goldenLineAdd($xmlData = array(), OfapiClient $client, $branches= array(), $regions=array())
{
	foreach ($xmlData as $key => $offer  )
	
	{
		 foreach ($offer as $key=> $value)
			 	
			
		 	$body= '<body>'.$offer['company_description'].$offer['position_description'].$offer['Requirements'].$offer['opportunites'].'</body>';
		 	
		 	$offer_data = [
		 		'native_id' => $offer['jobid'],
		 		'start_date' => (new DateTime())->format('Y-m-d'),
		 		'exp_date' => (new DateTime())->add(new DateInterval('P35D'))->format('Y-m-d'),
		 		'company' => 'PARETTi',
		 		'position' => $offer['name'],
		 		'refnum' => '123/45',
		 		'contact_email' => 'opole@paretti.pl',
		 		'city' => $offer['CountryRegionName'],
		 		'regions' => [$regions[0]['id']],
		 		'branches' => [$branches[0]['id'], $branches[1]['id']],
		 		'html_body' => $body,
		 ];	
		
		//	print_r($offer_data).'<br>';
	//	print_r($client->edit_offer($offer_data));
		// print_r($client->regions());		 	
	}

}

print_r(($client->edit_offer($offer_data)));

//goldenLineAdd($xmlValidation->create_data(),$client, $branches, $regions);





?>
