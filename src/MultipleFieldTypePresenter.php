<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class MultipleFieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypePresenter extends FieldTypePresenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var MultipleFieldType
     */
    protected $object;

    /**
     * Return a simple lists string.
     *
     * @return null|string
     */
    public function lists($value = null, $key = null)
    {
        /* @var Relation $value */
        $relation = $this->object->getValue();

        /* @var EloquentModel $related */
        $related = $this->object->getRelatedModel();

        /* @var EloquentCollection $relations */
        if ($relations = $relation->get()) {
            return $relations->lists($value ?: $related->getTitleName(), $key ?: $related->getKeyName());
        }

        return [];
    }
}
