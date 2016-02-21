<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\MultipleFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class GetValueDefinition
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Command
 */
class GetValueDefinition implements SelfHandling
{

    /**
     * The value table.
     *
     * @var ValueTableBuilder
     */
    protected $table;

    /**
     * Create a new HydrateValueTable instance.
     *
     * @param ValueTableBuilder $table
     */
    public function __construct(ValueTableBuilder $table)
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

        $key = 'multiple.value.' . get_class($container->make($this->table->config('related')));

        /* @var Addon $addon */
        foreach ($addons->withConfig($key) as $addon) {
            $definition = $config->get($addon->getNamespace($key));
        }

        $definition = $config->get($fieldType->getNamespace($key), $definition);

        return $definition;
    }
}
