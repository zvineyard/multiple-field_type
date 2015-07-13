<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MultipleFieldTypeAccessor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldTypeAccessor extends FieldTypeAccessor
{

    /**
     * The field type object.
     * This is for IDE support.
     *
     * @var MultipleFieldType
     */
    protected $fieldType;

    /**
     * Set the value.
     *
     * @param $value
     */
    public function set($value)
    {
        if (is_array($value)) {
            $this->fieldType->getRelation()->sync(array_filter($value));
        }

        if ($value instanceof Collection) {
            $this->fieldType->getRelation()->sync($value);
        }
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->fieldType->getRelation();
    }
}
