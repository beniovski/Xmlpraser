<?php

mb_internal_encoding('UTF-8');

require 'vendor/autoload.php';
require 'client.php';


define('APP_KEY', '2f7ea8a7782923927322122292e10017');
define('SECRET_KEY', 'cb8c3125364aff93ecb19b371f9abd69');
define('HASH_KEY', '57737f45c02431689af0df6ad8ec4052');

$client = new OfapiClient(APP_KEY, SECRET_KEY, HASH_KEY);
$branches = $client->branches();
$regions = $client->regions();
//print_r($client->specialities());
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
    'html_body' => 'Put entire contents of BODY tag here',
];
//print_r($client->edit_offer($offer_data));
//print_r($client->offer_status($offer_data['native_id']));
//print_r($client->offer_statistics($offer_data['native_id']));
?>
