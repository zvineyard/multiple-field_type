<?php namespace Anomaly\MultipleFieldType;

use Anomaly\MultipleFieldType\Command\BuildOptions;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class MultipleFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldType extends FieldType implements SelfHandling
{

    use DispatchesCommands;

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
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'handler' => 'Anomaly\MultipleFieldType\MultipleFieldTypeOptions@handle'
    ];

    /**
     * The select input options.
     *
     * @var null|array
     */
    protected $options = null;

    /**
     * Get the relation.
     *
     * @return BelongsToMany
     */
    public function getRelation()
    {
        $entry = $this->getEntry();

        return $entry->belongsToMany(
            array_get($this->getConfig(), 'related'),
            $this->getPivotTableName(),
            'entry_id',
            'related_id'
        );
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->dispatch(new BuildOptions($this));
        }

        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the related model.
     *
     * @return null|mixed
     */
    public function getRelatedModel()
    {
        return $this->container->make(array_get($this->getConfig(), 'related'));
    }

    /**
     * Get the pivot table.
     *
     * @return string
     */
    public function getPivotTableName()
    {
        return $this->entry->getTableName() . '_' . $this->getField();
    }

    /**
     * Handle saving the form data ourselves.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        // See the accessor for how IDs are handled.
        $entry->{$this->getField()} = $this->getPostValue();
    }
}
