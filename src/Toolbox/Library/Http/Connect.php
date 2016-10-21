<?php
namespace Toolbox\Library\Http;

use Zend\Http\Client;
use Zend\Hydrator\Hydrator;

class Connect extends Client
{
    protected $client;

    /**
     * Requires an end point and a token, nothing else
     * @param $endpoint
     * @param $token
     * @return array
     * @throws \Exception
     */
    public function basicOauthGetConnect($endpoint,$token)
    {
        $client = new Client();
        $client->setUri($endpoint);
        $client->setMethod('GET');
        $client->setOptions(
            [
                'maxredirects' => 0,
                'timeout' => 60
            ]
        );

        $client->setAdapter('Zend\Http\Client\Adapter\Curl');  //deals with ssl errors

        $client->setHeaders(['Accept' => 'application/json', 'Authorization' => 'Bearer '.$token ]);

        try {
            $response = $client->send();
        } catch (\Exception $e) {
            throw new \Exception($e);

        }

        $responseObject = json_decode($response->getBody());

        if (is_null($responseObject))
        {
            return false;
        }

        $hydrator = new Hydrator\ObjectProperty;

        return $hydrator->extract($responseObject);
    }

    /**
     * @param $endpoint
     * @param $token
     * @param $postArray
     * @return array
     * @throws \Exception
     */
    public function basicOauthPostConnect($endpoint,$token,$postArray)
    {
        $client = new Client(
            $endpoint,
            [
                'maxredirects' => 0,
                'timeout' => 60
            ]
        );

        $client->setMethod('POST');

        $client->setAdapter('Zend\Http\Client\Adapter\Curl');  //to deal with ssl errors

        $client->setHeaders(
            [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        );

//        $data = array(
//            $postArray
//        );

        $json = json_encode($postArray);

        $client->setRawBody($json, 'application/json');

        try {
            $response = $client->send();
        } catch (\Exception $e) {
            throw new \Exception($e);

        }

        $responseObject = json_decode($response->getBody());

        if (is_null($responseObject))
        {
            return false;
        }

        $hydrator = new Hydrator\ObjectProperty;

        return $hydrator->extract($responseObject);

    }






}



