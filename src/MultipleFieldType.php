<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\RelationFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class MultipleFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldType extends FieldType implements RelationFieldTypeInterface
{

    /**
     * Defer processing of this field
     * type until after the entry is saved.
     *
     * @var bool
     */
    protected $deferred = true;

    /**
     * No database column.
     *
     * @var bool
     */
    protected $columnType = false;

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.multiple::input';

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules = [
        //'validate_choices'
    ];

    /**
     * The extra validators.
     *
     * @var array
     */
    protected $validators = [
        'validate_choices' => 'Anomaly\MultipleFieldType\MultipleFieldTypeValidator@validate'
    ];

    /**
     * The options handler.
     *
     * @var string
     */
    protected $options = 'Anomaly\MultipleFieldType\MultipleFieldTypeOptions@handle';

    /**
     * The list of related IDs.
     *
     * @var array
     */
    protected $list = null;

    /**
     * Get the relation.
     *
     * @param EntryInterface $model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|null
     */
    public function getRelation(EntryInterface $model)
    {
        return $model->belongsToMany(
            array_get($this->config, 'related'),
            $this->getPivotTableName(),
            $this->getForeignKey(),
            $this->getOtherKey()
        );
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return app()->call(array_get($this->config, 'handler', $this->options), ['fieldType' => $this]);
    }

    /**
     * Get the related model.
     *
     * @return null|mixed
     */
    public function getRelatedModel()
    {
        return app()->make(array_get($this->config, 'related'));
    }

    /**
     * Get the related IDs.
     *
     * @return array
     */
    public function getList()
    {
        return $this->list = $this->list !== null ? $this->list : $this->getValue()->get()->lists('id');
    }

    /**
     * Get the pivot table.
     *
     * @return mixed
     */
    public function getPivotTableName()
    {
        $default = 'multiple_' . $this->getField() . '_relations';

        return array_get($this->config, 'pivot_table', $default);
    }

    /**
     * Get the foreign key.
     *
     * @return mixed
     */
    public function getForeignKey()
    {
        return array_get($this->config, 'foreign_key', 'entry_id');
    }

    /**
     * Get the related key.
     *
     * @return mixed
     */
    public function getOtherKey()
    {
        return array_get($this->config, 'related_key', 'related_id');
    }
}
