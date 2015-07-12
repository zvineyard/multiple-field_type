<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildOptions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Command
 */
class BuildOptions implements SelfHandling
{

    /**
     * The field type instance.
     *
     * @var MultipleFieldType
     */
    protected $fieldType;

    /**
     * Create a new BuildOptions instance.
     *
     * @param MultipleFieldType $fieldType
     */
    function __construct(MultipleFieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Handle the command.
     *
     * @param Container $container
     */
    public function handle(Container $container)
    {
        $container->call(array_get($this->fieldType->getConfig(), 'handler'), ['fieldType' => $this->fieldType]);
    }
}
