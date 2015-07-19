<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
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
     *
     *
     * @return null|string
     */
    public function lists($value, $key = null)
    {
        /* @var Relation $value */
        $relation = $this->object->getValue();

        if (is_array($relation)) {
            return $relation;
        }

        return call_user_func_array([$relation, 'lists'], array_filter(compact('value', 'key')));
    }
}
