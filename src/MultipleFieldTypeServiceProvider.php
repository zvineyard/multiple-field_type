<?php namespace Anomaly\MultipleFieldType;

/**
 * Class MultipleFieldTypeServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypeServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['events']->listen(
            'streams::assignment.create',
            'Anomaly\Streams\Addon\FieldType\Multiple\MultipleFieldTypeListener'
        );
    }
}
