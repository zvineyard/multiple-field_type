<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\MultipleFieldType\Tree\ValueTreeBuilder;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class GetValueDefinition
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
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
     * @param AddonCollection       $addons
     * @param Repository            $config
     * @return array
     */
    public function handle(MultipleFieldType $fieldType, AddonCollection $addons, Repository $config)
    {
        $definition = [];

        /* @var Addon $addon */
        foreach ($addons->withConfig('value.' . $this->tree->config('related')) as $addon) {
            $definition = $config->get($addon->getNamespace('value.' . $this->tree->config('related')));
        }

        $definition = $config->get($fieldType->getNamespace('value.' . $this->tree->config('related')), $definition);

        return $definition;
    }
}
