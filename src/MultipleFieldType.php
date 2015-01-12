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
 * @package       Anomaly\Streams\Addon\FieldType\Multiple
 */
class MultipleFieldType extends FieldType implements RelationFieldTypeInterface
{

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.multiple::input';

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
            $this->getPivotTable(),
            $this->getForeignKey(),
            $this->getRelatedKey()
        );
    }

    /**
     * Get the options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = [];

        foreach ($this->getModelOptions() as $option) {

            $option['selected'] = in_array($option['value'], $this->getValue());

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
     * @return null
     */
    protected function getRelatedModel()
    {
        $model = array_get($this->config, 'title');

        if (!$model) {
            return null;
        }

        return app()->make($model);
    }

    /**
     * Get the value.
     *
     * @return array
     */
    public function getValue()
    {
        return (array)parent::getValue();
    }

    /**
     * Get the pivot table.
     *
     * @return mixed
     */
    public function getPivotTable()
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
    public function getRelatedKey()
    {
        return array_get($this->config, 'related_key', 'related_id');
    }
}
