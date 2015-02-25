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
     * @throws \Exception
     */
    public function handle(MultipleFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        if (!$model instanceof EloquentModel) {
            return [];
        }

        return $model->all()->lists(
            array_get($fieldType->getConfig(), 'title', $model->getTitleName()),
            $model->getKeyName()
        );
    }
}
