<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MultipleFieldTypeAccessor
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
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
        if (is_string($value)) {
            $this->fieldType->getRelation()->sync($this->organizeSyncValue(explode(',', $value)));
        }

        if (is_array($value)) {
            $this->fieldType->getRelation()->sync($this->organizeSyncValue($value));
        }

        if ($value instanceof Collection) {
            $this->fieldType->getRelation()->sync($this->organizeSyncValue($value->filter()->all()));
        }

        if (!$value) {
            $this->fieldType->getRelation()->detach();
        }
    }

    /**
     * Organize the value for sync.
     *
     * @param array $value
     * @return array
     */
    protected function organizeSyncValue(array $value)
    {
        $value = array_filter($value);

        return array_combine(
            array_values($value),
            array_map(
                function ($key) {
                    return ['sort_order' => $key];
                },
                array_keys($value)
            )
        );
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
