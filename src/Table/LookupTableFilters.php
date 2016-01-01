<?php namespace Anomaly\MultipleFieldType\Table;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LookupTableFilters
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Table
 */
class LookupTableFilters implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param LookupTableBuilder $builder
     */
    public function handle(LookupTableBuilder $builder)
    {
        $stream = $builder->getTableStream();
        $filter = $stream->getTitleColumn();

        if ($filter == 'id') {
            return;
        }

        $builder->setFilters(
            [
                $filter
            ]
        );
    }
}
