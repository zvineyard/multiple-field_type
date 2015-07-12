<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MultipleFieldTypeOptions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypeOptions
{

    /**
     * Handle the options.
     *
     * @param MultipleFieldType $fieldType
     * @return array
     */
    public function handle(MultipleFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        /* @var Builder $query */
        $query = $model->newQuery();

        /* @var EloquentCollection $results */
        $results = $query->get();

        $fieldType->setOptions(
            array_filter(
                $results->lists(
                    $model->getTitleName(),
                    $model->getKeyName()
                )
            )
        );
    }
}
