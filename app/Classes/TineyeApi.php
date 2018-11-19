<?php

namespace App\Classes;

class TineyeApi
{

    private $apiPrivateKey;
    private $apiPublicKey;

    public function __construct($apiPrivateKey, $apiPublicKey)
    {
        $this->apiPrivateKey = $apiPrivateKey;
        $this->apiPublicKey = $apiPublicKey;
    }

    function searchImageUrl($imageUrl)
    {
        $apiUrl = 'https://api.tineye.com/rest/search/';
        $data = array(
            "offset" => "0",
            "limit" => "20",
            "image_url" => $imageUrl
        );

        $sortedData = ksort($data);
        $queryData = http_build_query($data);
        $signatureData = strtolower($queryData);
        $httpVerb = "GET";
        $date = time();
        $nonce = uniqid();

        $stringToSign = $this->apiPrivateKey.$httpVerb.$date.$nonce.$apiUrl.$signatureData;
        $apiSignature = hash_hmac("SHA256", $stringToSign, $this->apiPrivateKey);

        $url = $apiUrl . "?api_key=" . $this->apiPublicKey. "&";
        $url .= $queryData . "&date=" . $date . "&nonce=" . $nonce . "&api_sig=" . $apiSignature;

        $apiResponse = json_decode(file_get_contents($url), True);

        return $apiResponse;
    }

}
