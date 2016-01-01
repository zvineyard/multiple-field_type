<?php namespace Anomaly\MultipleFieldType\Tree;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ValueTreeSegments
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Tree
 */
class ValueTreeSegments implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param ValueTreeBuilder $builder
     */
    public function handle(ValueTreeBuilder $builder)
    {
        $stream = $builder->getTreeStream();
        $column = $stream->getTitleColumn();

        if ($column == 'id') {
            return;
        }

        $builder->setSegments(
            [
                $column
            ]
        );
    }
}
