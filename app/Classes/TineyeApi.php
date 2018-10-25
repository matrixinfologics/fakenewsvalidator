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

    public function searchImage($imageData, $imageName)
    {
        $apiUrl = 'https://api.tineye.com/rest/search/';
        $httpVerb = "POST";
        // init CURL seesion
        $handle = curl_init();

        // content-type header
        $boundary = "---------------------" . md5(mt_rand() . microtime());
        $contentTypeHeader = "multipart/form-data; boundary=$boundary";

        $date = time();
        $nonce = uniqid();
        $limit = "10";

        $apiSigRaw = $this->apiPrivateKey.$httpVerb.$contentTypeHeader.$imageName.$date.$nonce.$apiUrl."limit=$limit";

        $apiSig = hash_hmac("SHA256", $apiSigRaw, $this->apiPrivateKey);

        $headerBoundary = $boundary;
        $boundary = '--'.$boundary;

        $post_str = $boundary . "\nContent-Disposition: form-data; name=\"image_upload\"; filename=\"$imageName\"\nContent_Type: application/octet-stream\n\n$imageData\n";
        $post_str .= $boundary . "\nContent-Disposition: form_data; name=\"api_key\"\n\n$this->apiPublicKey\n";
        $post_str .= $boundary . "\nContent-Disposition: form_data; name=\"date\"\n\n$date\n";
        $post_str .= $boundary . "\nContent-Disposition: form_data; name=\"nonce\"\n\n$nonce\n";
        $post_str .= $boundary . "\nContent-Disposition: form_data; name=\"api_sig\"\n\n$apiSig\n";
        $post_str .= $boundary . "\nContent-Disposition: form_data; name=\"limit\"\n\n$limit\n";
        $post_str .= $boundary . "--";

        curl_setopt($handle, CURLOPT_URL, $apiUrl);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_str);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Expect: 100-continue", "Content-Type: multipart/form-data; boundary=$headerBoundary"));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

        // Call API and convert results to a usable JSON object.
        $apiResponse = curl_exec($handle);
        $apiJsonResponse = json_decode($apiResponse, True);

        curl_close($handle);

        return $apiJsonResponse;
    }

}
