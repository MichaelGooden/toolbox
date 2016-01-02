<?php
namespace Toolbox\Library\ApplicationSettings;

use Toolbox\Entity\AppSettings;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Paginator\Paginator;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;

class AppSettingService
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $appSettingRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @param ObjectRepository $appSettingRepository
     * @param ObjectManager $entityManager
     */
    public function __construct(
        ObjectRepository $appSettingRepository,
        ObjectManager $entityManager
    )
    {
        $this->appSettingRepository = $appSettingRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->appSettingRepository->findAll();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function findByOptionId($key)
    {
        return $this->appSettingRepository->findOneByOptionId($key);
    }

    /**
     * @param AppSettings $dataObject
     * @return AppSettings|mixed
     * @throws \Exception
     */
    public function update( AppSettings $dataObject )
    {
        try {
            $this->entityManager->persist($dataObject);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return $dataObject;
    }

    /**
     * @param $page
     * @param $count
     * @return Paginator
     */
    public function getPaged($page, $count) {
        $adapter    = new SelectableAdapter($this->appSettingRepository);
        $paginator  = new Paginator($adapter);

        return $paginator->setCurrentPageNumber( (int) $page )->setItemCountPerPage( (int) $count );

    }

    /**
     *
     * To use this:
     * optionId = the master id i.e. agent_settings
     * $params to contain a key value pair i.e. agent_id => ['number_seperator' => 'x' , 'time_zone' => 'UTC'] always use value as an array
     *
     * @param $optionId
     * @param $params
     * @return AppSettings|mixed
     */
    public function saveSettings($optionId,$params)
    {



//        $params = [
//            'identity'  => user id for example,
//            'key'       => '',
//            'value'     => ''
//        ];

//        [
//            'optionId' => [
//                'identity' => [
//                    'key1' => 'value1',
//                    'key2' => 'value2',
//                    'key3' => 'value3'
//                ]
//            ]
//        ];

        $appObject = $this->findByOptionId($optionId);

        if ( ! $appObject instanceof AppSettings )
        {
            $appObject = new AppSettings();
        }

        if (is_null($appObject->getOptionId()))
        {
            $appObject->setOptionId($optionId);
            $appObject->setOptionValue( [
                        $params['identity'] => [$params['key']=>$params['value']]
                    ]
            );
        } else {

            $array = $appObject->getOptionValue();

            if (empty($array[$params['identity']])) {
                $array[$params['identity']] = [$params['key']=>$params['value']];
            } else {
                $new_array = $array[$params['identity']];
                $new_array[$params['key']] = $params['value'];

                $array[$params['identity']] = $new_array;

            }

            $appObject->setOptionValue($array);

        }

        $appObject = $this->update($appObject);

        return $appObject;

    }

    /**
     * Get the required settings
     * @param $params
     * @return string
     */
    public function getSetting($params)
    {
        $appObject = $this->findByOptionId($params['option_id']);

        if (!$appObject instanceof AppSettings)
        {
            return false;
        }

        $option_array = $appObject->getOptionValue();

        if (isset($option_array[$params['identity']][$params['key']]))
        {
            return $option_array[$params['identity']][$params['key']];
        }

        return false;
    }

    /**
     * Remove a date from the array
     * @param $params
     * @return bool
     */
    public function deleteSetting($params)
    {
        $appObject = $this->findByOptionId($params['option_id']);

        if (!$appObject instanceof AppSettings)
        {
            return false;
        }

        $option_array = $appObject->getOptionValue();

        if (!isset($option_array[$params['identity']][$params['key']]))
        {
            return false;
        }

        $array = $option_array[$params['identity']][$params['key']];
        //$array = array_flip($array);
        unset($array[$params['delete_key']]);
        $array = array_values($array);

        /**
         * Save the new settings
         */

        $new_params = [
            'identity'  => $params['identity'],
            'key'       => $params['key'],
            'value'     => $array
        ];

        $appObject = $this->saveSettings($params['option_id'],$new_params);

        if (!$appObject instanceof AppSettings)
        {
            return false;
        }

        return true;

    }


} 