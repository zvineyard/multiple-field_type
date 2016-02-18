<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\MultipleFieldType\Tree\ValueTreeBuilder;
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
     * The value tree.
     *
     * @var ValueTreeBuilder
     */
    protected $tree;

    /**
     * Create a new HydrateValueTree instance.
     *
     * @param ValueTreeBuilder $tree
     */
    public function __construct(ValueTreeBuilder $tree)
    {
        $this->tree = $tree;
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

        $key = 'multiple.value.' . get_class($container->make($this->tree->config('related')));

        /* @var Addon $addon */
        foreach ($addons->withConfig($key) as $addon) {
            $definition = $config->get($addon->getNamespace($key));
        }

        $definition = $config->get($fieldType->getNamespace($key), $definition);

        return $definition;
    }
}
