<?php namespace Anomaly\MultipleFieldType\Handler;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Illuminate\Database\Eloquent\Builder;

class Related
{

    /**
     * Handle the options.
     *
     * @param  MultipleFieldType $fieldType
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
            $results->pluck(
                $model->getTitleName(),
                $model->getKeyName()
            )->all()
        );
    }
}
