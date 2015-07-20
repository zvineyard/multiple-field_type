<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MultipleFieldTypeQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypeQuery
{

    /**
     * Handle the filter query.
     *
     * @param Builder              $query
     * @param FieldFilterInterface $filter
     * @param TableBuilder         $builder
     */
    public function filter(Builder $query, FieldFilterInterface $filter, TableBuilder $builder)
    {
        $stream = $builder->getTableStream();

        $table = $stream->getEntryTableName() . '_' . $filter->getField();

        $query->join(
            $table . ' AS filter_' . $filter->getField(),
            $stream->getEntryTableName() . '.id',
            '=',
            'filter_' . $filter->getField() . '.entry_id'
        )->where('filter_' . $filter->getField() . '.entry_id', $filter->getValue());
    }
}
