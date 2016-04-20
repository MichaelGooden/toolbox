<?php
namespace Toolbox\Library\Http;

use Zend\Http\Client;
use Zend\Http\Response;
use Zend\Stdlib\Hydrator AS Hydrator;

class Authorise extends Client
{
    protected $client;

    public function getOauthTokenFromAuthoriseGrant($params)
    {
        $client = new Client($params['sso_oauth_url'],
            array(
                'maxredirects' => 0,
                'timeout' => 30,
                'sslcafile' => 'data/ca-bundle.pem'
            )
        );

        $client->setMethod('POST');
        $client->setEncType($params['encoding_type']);
        $params = array(
            'redirect_uri' => $params['sso_redirect_uri'],
            'client_id' => $params['sso_client_id'],
            'client_secret' => $params['sso_secret'],
            'code' => $params['code'],
            'grant_type' => $params['grant_type'],
            'response_type' => $params['response_type']
        );

        $client->setParameterPost($params);

        $response = $client->send();

        if (!$response instanceof Response)
        {
            return false;
        }

        $data = json_decode($response->getBody());

        if ((!isset($data->access_token))
            OR (!isset($data->expires_in))
            OR (!isset($data->token_type))
            OR (!isset($data->scope))
            OR (!isset($data->refresh_token))  )
        {
            return ['status' => false , 'message' => 'Invalid response'];
        }

        $date = new \DateTime();
        $interval = $data->expires_in;
        $date->add(new \DateInterval('PT' . $interval . 'S'));

        return [
            'status' => true,
            'token' => $data->access_token,
            'type' => $data->token_type,
            'expires' => $date,
            'scope' => $data->scope,
            'refresh_token' => $data->refresh_token
        ];

    }

}
