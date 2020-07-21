<?php

namespace iLaravel\iWindy\Vendor;

class WindyPoint
{
    public $service_url = "https://api.windy.com/api/point-forecast/v2";

    public $params = [
        "lat" => 33.560000,
        "lon" => 53.447500,
        "model" => "gfs",
        "parameters" => ["wind", "temp"],
        "levels" => ["surface", "800h", "300h"],
    ];

    public function request() {
        $this->params['key'] = config('services.windy.key');
        $headers = array(
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->service_url);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $this->params ) );
        return json_decode(curl_exec($ch));
    }
}
