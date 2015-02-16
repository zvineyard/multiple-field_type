<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\RelationFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * Get the relation.
     *
     * @param EntryModel $model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed|null
     */
    public function getRelation(EntryModel $model)
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
        $options = [];

        $value = $this->getRelatedIds();

        foreach ($this->getModelOptions() as $option) {

            $option['selected'] = in_array($option['value'], $value);

            $options[] = $option;
        }

        return $options;
    }

    /**
     * Get options from the model.
     *
     * @return array
     */
    protected function getModelOptions()
    {
        $model = $this->getRelatedModel();

        if (!$model instanceof EloquentModel) {
            return [];
        }

        $options = [];

        foreach ($model->all() as $entry) {

            $value = $entry->getKey();

            if ($title = array_get($this->config, 'title')) {
                $title = $entry->{$title};
            }

            if (!$title) {
                $title = $entry->getTitle();
            }

            $entry = $entry->toArray();

            $options[] = compact('value', 'title', 'entry');
        }

        return $options;
    }

    /**
     * Get the related model.
     *
     * @return null|mixed
     */
    protected function getRelatedModel()
    {
        $model = array_get($this->config, 'related');

        if (!$model) {
            throw new \Exception('No related model set for [' . $this->getField() . ']');
        }

        return app($model);
    }

    /**
     * Get the related IDs.
     *
     * @return array
     */
    protected function getRelatedIds()
    {
        return $this->getValue()->get()->lists('id');
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
