<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor;
use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * @param EloquentModel  $entry
     * @param                $value
     */
    public function set(EloquentModel $entry, $value)
    {
        $this->fieldType->getRelation($entry)->sync((array)$value);
    }

    /**
     * Get the value.
     *
     * @param EloquentModel $entry
     * @return mixed
     */
    public function get(EloquentModel $entry)
    {
        return $this->fieldType->getRelation($entry);
    }
}
