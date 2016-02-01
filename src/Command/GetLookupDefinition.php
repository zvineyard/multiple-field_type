<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\MultipleFieldType\Table\LookupTableBuilder;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class GetLookupDefinition
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Command
 */
class GetLookupDefinition implements SelfHandling
{

    /**
     * The lookup table.
     *
     * @var LookupTableBuilder
     */
    protected $table;

    /**
     * Create a new HydrateLookupTable instance.
     *
     * @param LookupTableBuilder $table
     */
    public function __construct(LookupTableBuilder $table)
    {
        $this->table = $table;
    }

    /**
     * Handle the command.
     *
     * @param MultipleFieldType $fieldType
     * @param AddonCollection   $addons
     * @param Container         $container
     * @param Repository        $config
     * @return array
     */
    public function handle(
        MultipleFieldType $fieldType,
        AddonCollection $addons,
        Container $container,
        Repository $config
    ) {
        $definition = [];

        $key = 'multiple.lookup.' . get_class($container->make($this->table->config('related')));

        /* @var Addon $addon */
        foreach ($addons->withConfig($key) as $addon) {
            $definition = $config->get($addon->getNamespace($key));
        }

        $definition = $config->get($fieldType->getNamespace($key), $definition);

        return $definition;
    }
}
