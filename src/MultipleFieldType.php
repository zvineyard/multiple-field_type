<?php namespace Anomaly\Streams\Addon\FieldType\Multiple;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;

class MultipleFieldType extends FieldType
{

    public function getRelation()
    {
        return $this->hasOne('Foo');
    }

    protected function getOptions()
    {
        $model = $this->getRelatedModel();

        if (!$model instanceof EloquentModel) {

            return [];
        }

        return $model->all()->lists('name', 'id');
    }

    protected function getRelatedModel()
    {
        $model = $this->getConfig('related');

        if (!$model) {

            return null;
        }

        return app()->make($model);
    }
}
