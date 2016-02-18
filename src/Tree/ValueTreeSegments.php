<?php namespace Anomaly\MultipleFieldType\Tree;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ValueTreeSegments
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
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
