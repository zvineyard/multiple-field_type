<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class MultipleFieldTypeServiceProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The addon listeners.
     *
     * @var array
     */
    protected $listeners = [
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated' => [
            'Anomaly\MultipleFieldType\Listener\CreatePivotTable'
        ],
        'Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted' => [
            'Anomaly\MultipleFieldType\Listener\DropPivotTable'
        ]
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        'Anomaly\MultipleFieldType\MultipleFieldTypeAccessor' => 'Anomaly\MultipleFieldType\MultipleFieldTypeAccessor'
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'streams/multiple-field_type/json/{key}'     => 'Anomaly\MultipleFieldType\Http\Controller\LookupController@json',
        'streams/multiple-field_type/index/{key}'    => 'Anomaly\MultipleFieldType\Http\Controller\LookupController@index',
        'streams/multiple-field_type/selected/{key}' => 'Anomaly\MultipleFieldType\Http\Controller\LookupController@selected'
    ];
}
