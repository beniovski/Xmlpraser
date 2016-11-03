<?php

use GuzzleHttp\Client;

class OfapiClient {
    private $app_key;
    private $secret_key;
    private $hash_key;
    private $client;

    public function __construct($app_key, $secret_key, $hash_key) {
        $this->app_key = $app_key;
        $this->secret_key = $secret_key;
        $this->hash_key = $hash_key;
        $this->client = new Client([
            'base_uri' => 'https://panel.goldenline.pl',
        ]);
    }

    private function sign_request($endpoint, $ts) {
        return hash('sha256', $this->app_key.$this->secret_key.$endpoint.(string)$ts);
    }

    private function request_params($endpoint) {
        $ts = time();
        return [
            'ts' => $ts,
            'app_key' => $this->app_key,
            'sign' => $this->sign_request($endpoint, $ts),
        ];
    }

    private function get_endpoint($endpoint) {
        $params = $this->request_params($endpoint);
        return $this->client->get($endpoint, [
            'query' => $params,
        ])->getBody()->getContents();
    }

    private function post_endpoint($endpoint, $data) {
        $params = $this->request_params($endpoint);
        $data['hashkey'] = $this->hash_key;
        return $this->client->post($endpoint, [
            'query' => $params,
            'form_params' => ['json' => json_encode($data)],
        ])->getBody()->getContents();
    }

    public function branches() {
        return json_decode($this->get_endpoint('/ofapi/others/branches/'), true)['branches'];
    }

    public function regions() {
        return json_decode($this->get_endpoint('/ofapi/others/regions/'), true)['regions'];
    }

    public function specialities() {
        return json_decode($this->get_endpoint('/ofapi/others/specialities/'), true)['specialities'];
    }

    public function offer_status($native_id) {
        return json_decode(
            $this->post_endpoint('/ofapi/offer/status/', ['native_id' => $native_id]),
            true
        );
    }

    public function edit_offer($offer_data) {
        return json_decode(
            $this->post_endpoint('/ofapi/offer/edit/', $offer_data),
            true
        );
    }

    public function offer_statistics($native_id) {
        return json_decode(
            $this->post_endpoint('/ofapi/offer/statistics/', ['native_id' => $native_id]),
            true
        );
    }
}

?>
