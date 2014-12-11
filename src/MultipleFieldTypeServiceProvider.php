<?php namespace Anomaly\Streams\Addon\FieldType\Multiple;

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
            'Anomaly.Streams.Platform.Assignment.Event.*',
            'Anomaly\Streams\Addon\FieldType\Multiple\MultipleFieldTypeListener'
        );
    }
}
 