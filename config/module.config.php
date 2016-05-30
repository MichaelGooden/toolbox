<?php
namespace Toolbox;
/**
 * Toolbox
 * @author Brendan <b.nash at southeaster dot com
 * @Contributors:
 */
use Toolbox\Controller\Factory\ToolboxControllerFactory;
use Toolbox\Controller\ToolboxController;
use Toolbox\Library\ApplicationSettings\ApplicationSettings;
use Toolbox\Library\ApplicationSettings\ApplicationSettingsFactory;
use Toolbox\Library\ApplicationSettings\AppSettingService;
use Toolbox\Library\ApplicationSettings\AppSettingServiceFactory;
use Toolbox\Library\ApplicationSettings\SettingsHelperFactory;
use Toolbox\Library\Calendar\DayNameHelper;
use Toolbox\Library\Countries\CanadaStatesService;
use Toolbox\Library\Countries\CanadaStatesServiceFactory;
use Toolbox\Library\Countries\CountriesService;
use Toolbox\Library\Countries\CountriesServiceFactory;
use Toolbox\Library\Countries\CountryNameHelperFactory;
use Toolbox\Library\Countries\UsStatesService;
use Toolbox\Library\Countries\UsStatesServiceFactory;
use Toolbox\Library\Currency\CurrencyFormatHelperFactory;
use Toolbox\Library\Currency\CurrencyMapper;
use Toolbox\Library\Currency\CurrencyMapperFactory;
use Toolbox\Library\Currency\CurrencyOptionsHelperFactory;
use Toolbox\Library\ExRates\ExchangeRateService;
use Toolbox\Library\ExRates\ExchangeRateServiceFactory;
use Toolbox\Library\ExRates\UpdateExchangeRate;
use Toolbox\Library\ExRates\UpdateExchangeRateFactory;
use Toolbox\Library\Mail\Options\ModuleOptions;
use Toolbox\Library\Mail\Options\ModuleOptionsFactory;
use Toolbox\Library\Mail\Service\MailService;
use Toolbox\Library\Mail\Service\MailServiceFactory;
use Toolbox\Library\Notifications\NotificationCountHelperFactory;
use Toolbox\Library\Notifications\NotificationHelperFactory;
use Toolbox\Library\Notifications\NotificationService;
use Toolbox\Library\Notifications\NotificationServiceFactory;
use Toolbox\Library\Notifications\NotificationsLogger;
use Toolbox\Library\Notifications\NotificationsLoggerFactory;
use Toolbox\Library\ReferrerValidator\ReferrerValidator;
use Toolbox\Library\ApplicationStatus\ApplicationStatus;
use Toolbox\Library\ApplicationStatus\ApplicationStatusFactory;
use Toolbox\Library\ReferrerValidator\ReferrerValidatorFactory;
use Toolbox\Library\Session\CookieHelperFactory;
use Toolbox\Library\Session\CookieService;
use Toolbox\Library\Session\CookieServiceFactory;

return [
    'controllers' => [
        'factories' => [
            ToolboxController::class => ToolboxControllerFactory::class,
        ]
    ],
    'service_manager'    => [
        'factories'  => [
            NotificationService::class => NotificationServiceFactory::class,
            NotificationsLogger::class => NotificationsLoggerFactory::class,
            CurrencyMapper::class => CurrencyMapperFactory::class,
            ExchangeRateService::class => ExchangeRateServiceFactory::class,
            MailService::class   => MailServiceFactory::class,
            ModuleOptions::class => ModuleOptionsFactory::class,
            ApplicationSettings::class  => ApplicationSettingsFactory::class,
            CountriesService::class => CountriesServiceFactory::class,
            AppSettingService::class => AppSettingServiceFactory::class,
            UsStatesService::class => UsStatesServiceFactory::class,
            CanadaStatesService::class => CanadaStatesServiceFactory::class,
            CookieService::class => CookieServiceFactory::class,
            ApplicationStatus::class => ApplicationStatusFactory::class,
            UpdateExchangeRate::class => UpdateExchangeRateFactory::class,
            ReferrerValidator::class => ReferrerValidatorFactory::class
        ]
    ],
    //Little faster setting templates like this
    'view_manager'       => [
        'template_map' => [
            'toolbox/toolbox/notifications' => __DIR__ . '/../view/notifications/overview.phtml',
            'toolbox/toolbox/view'   => __DIR__ . '/../view/notifications/view.phtml'
        ]
    ],
    'view_helpers'  => [
        'invokables'    => [
            'DayNameHelper'           => DayNameHelper::class,
        ],
        'factories' => [
            'NotificationCountHelper' => NotificationCountHelperFactory::class,
            'NotificationHelper'      => NotificationHelperFactory::class,
            'CurrencyFormatHelper'    => CurrencyFormatHelperFactory::class,
            'SettingHelper'           => SettingsHelperFactory::class,
            'CountryNameHelper'       => CountryNameHelperFactory::class,
            'CurrencyOptionsHelper'   => CurrencyOptionsHelperFactory::class,
            'CookieHelper'            => CookieHelperFactory::class
        ]
    ],
    'router'             => [
        'routes' => [
            'notifications' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/notifications',
                    'defaults' => [
                        'controller' => ToolboxController::class,
                        'action'     => 'notifications'
                    ]
                ],

                'may_terminate' => true,
                'child_routes' => [
                    'overview' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'       => '/overview',
                            'defaults' => [
                                'controller' => ToolboxController::class,
                                'action'     => 'notifications'
                            ],
                        ],
                    ],
                    'test' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'       => '/test',
                            'defaults' => [
                                'controller' => ToolboxController::class,
                                'action'     => 'test-notifications'
                            ],
                        ],
                    ],
                    'view' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'       => '/view/type_id/:type_id[/page/:page][/count/:count]',
                            'defaults' => [
                                'controller' => ToolboxController::class,
                                'action'     => 'view'
                            ],
                            'constraints' => [
                                'type_id' => '[0-9]+',
                                'page'    => '[0-9]+',
                                'count'   => '[0-9]+',
                            ],
                        ],
                    ],

                ]
            ],
        ]
    ],
    'doctrine'           => [
        'driver' => [
            'application_driver'  => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Toolbox/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Toolbox\Entity' => 'application_driver'
                ]
            ]
        ],
    ]
];