<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Model\EloquentModel;

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

        if (!$model instanceof EloquentModel) {
            return [];
        }

        $query = $model->newQuery();

        $title = array_get($fieldType->getConfig(), 'title');
        $key   = array_get($fieldType->getConfig(), 'key');

        return array_filter(
            $query->get()->lists(
                $title ?: $model->getTitleName(),
                $key ?: $model->getKeyName()
            )
        );
    }
}
