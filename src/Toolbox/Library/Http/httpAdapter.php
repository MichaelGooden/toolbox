<?php
namespace Toolbox\Library\Http;

use Zend\Http\Client;

class httpAdapter extends Client
{
    protected $client;

    protected $method;

    protected $uri;

    protected $options;

    /**
     * Step 2: Set the client
     */
    public function setClient($max = 0 , $time = 60 , $adapter = 'Zend\Http\Client\Adapter\Curl')
    {
        $uri = $this->getUri();

        $this->client = new Client(
            $uri,
            array(
                'adapter' => $adapter,
                'maxredirects' => $max,
                'timeout' => $time,

            )
        );
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $method
     * @return void|Client
     */
    public function setMethod($method = 'GET')
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param array $options
     * @return void|Client
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function authenticate()
    {

        $client  = $this->getClient();
        $method  = $this->getMethod();
        $options = $this->getOptions();

        $client->setMethod($method);
        $client->setHeaders($options);

        try {
            $response = $client->send();
        } catch (\Exception $e) {
            throw new \Exception($e);

        }

        return $response;

    }


}



