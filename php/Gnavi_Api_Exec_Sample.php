<?php

class Gnavi_Api_Exec_Sample
{
    private $endpoint = "http://api.gnavi.co.jp/RestSearchAPI/20150630/";
    private $access_key = "input your accessKey";
    private $format = "json";

    private $latitude = 0;
    private $longitude = 0;
    private $range = 1;

    public function setAccessKey($access_key)
    {
        $this->access_key = $access_key;
        return $this;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function setRange($range)
    {
        $this->range = $range;
        return $this;
    }

    public function execApi()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint . '?' . http_build_query($this->getParam(), '', "&"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $response = curl_exec($ch);
        if (!$response) {
            throw new Exception("api response fail.");
        }

        return $response;

    }

    public function toString(){
        $reflector = new ReflectionClass('Sample');
        $properties = $reflector->getProperties();
        foreach ($properties as $property){
            print_r($property->getName().":" . $this->{$property->getName()}."\n");
        }
    }

    public function getParam()
    {
        return [
            "keyid" => $this->access_key,
            "format" => $this->format,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "range" => $this->range,
        ];
    }

}


// The following run sample.
$object = new Gnavi_Api_Exec_Sample();
$json = $object->setAccessKey("input your accessKey")
               ->setFormat("json")
//               ->toString(); // debug
               ->execApi();

print_r(json_decode($json));

