<?php
namespace Toolbox\Library\Session;

/**
 * Use this service to store data during a current session only, will be erased when the browser is closed
 */

use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;

class SessionService
{

    /**
     * @var \Zend\Authentication\Storage\Session
     */
    protected $storage;

    /**
     * @param StorageInterface $storage
     */
    function __construct(
        StorageInterface $storage = null
    )
    {
        $this->storage = $storage ? : new Session('RoleBasedUserStorage');
    }

    /**
     * @param $dataName
     * @param $dataValue
     * @return array
     */
    public function setData($dataName, $dataValue)
    {
        $currentData = $this->getData();

        $newData = [
            $dataName => $dataValue
        ];

        /**
         * Note the latter array overwrites the former
         */
        $appendedData = array_merge( $currentData , $newData );

        $this->updateSessionData($appendedData);

        return $appendedData;

    }

    /**
     * @return bool|mixed
     */
    public function getData()
    {
        if ($this->storage->isEmpty()) {
            return [];
        }

        return $this->storage->read();

    }

    /**
     * Empty the session
     */
    public function clearData()
    {
        $this->storage->clear();
    }

    /**
     * @param $newData
     */
    public function updateSessionData($newData)
    {

        $this->storage->write($newData);
    }

    /**
     * @param $key
     * @return bool
     */
    public function getDataValue($key)
    {
        $data = $this->getData();

        if (isset($data[$key]))
        {
            return $data[$key];
        }

        return false;
    }

    /**
     * Clear a specific session key
     * @param $key
     * @return bool
     */
    public function clearDataValue($key)
    {
        $data = $this->getData();

        if (!isset($data[$key]))
        {
            return false;
        }

        unset($data[$key]);
        $this->updateSessionData($data);

        return true;

    }

}