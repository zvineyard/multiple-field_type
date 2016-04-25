<?php namespace Anomaly\MultipleFieldType\Table;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LookupTableFilters
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
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

            $builder->setFilters([]);

            return;
        }

        $builder->setFilters(
            [
                'search' => [
                    'fields' => [
                        $filter
                    ]
                ]
            ]
        );
    }
}
