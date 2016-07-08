<?php namespace Anomaly\MultipleFieldType;

use Anomaly\MultipleFieldType\Command\BuildOptions;
use Anomaly\MultipleFieldType\Command\HydrateValueTable;
use Anomaly\MultipleFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class MultipleFieldType
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType
 */
class MultipleFieldType extends FieldType implements SelfHandling
{

    use DispatchesJobs;

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
     * The filter view.
     *
     * @var string
     */
    protected $filterView = 'anomaly.field_type.multiple::filter';

    /**
     * The pre-defined handlers.
     *
     * @var array
     */
    protected $handlers = [
        //'fields'      => 'Anomaly\MultipleFieldType\Handler\Fields@handle',
        'related' => 'Anomaly\MultipleFieldType\Handler\Related@handle',
        //'assignments' => 'Anomaly\MultipleFieldType\Handler\Assignments@handle'
    ];

    /**
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'handler' => 'related',
        'mode'    => 'tags'
    ];

    /**
     * The select input options.
     *
     * @var null|array
     */
    protected $options = null;

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new MultipleFieldType instance.
     *
     * @param Repository $cache
     * @param Container  $container
     */
    public function __construct(Repository $cache, Container $container)
    {
        $this->cache     = $cache;
        $this->container = $container;
    }

    /**
     * Return the ids.
     *
     * @return array|mixed|static
     */
    public function ids()
    {
        // Return post data likely.
        if (is_array($array = $this->getValue())) {
            return $array;
        }

        /* @var EloquentCollection $relation */
        if ($relation = $this->getValue()) {
            return $relation->lists('id')->all();
        }

        return [];
    }

    /**
     * Return the config key.
     *
     * @return string
     */
    public function key()
    {
        $this->cache->put(
            'anomaly/multiple-field_type::' . ($key = md5(json_encode($this->getConfig()))),
            array_merge(
                $this->getConfig(),
                [
                    'field' => $this->getField(),
                    'entry' => get_class($this->getEntry())
                ]
            ),
            30
        );

        return $key;
    }

    /**
     * Value table.
     *
     * @return string
     */
    public function table()
    {
        $value   = $this->getValue();
        $related = $this->getRelatedModel();

        if ($value instanceof EntryCollection) {
            $value = $value->lists('id')->all();
        }

        if ($table = $this->config('value_table')) {
            $table = $this->container->make($table);
        } else {
            $table = $related->newMultipleFieldTypeValueTableBuilder();
        }

        /* @var ValueTableBuilder $table */
        $table->setConfig(new Collection($this->getConfig()))
            ->setSelected($value ?: [])
            ->setFieldType($this)
            ->setModel($related)
            ->build()
            ->load();

        return $table->getTableContent();
    }

    /**
     * Get the relation.
     *
     * @return BelongsToMany
     */
    public function getRelation()
    {
        $entry = $this->getEntry();
        $model = $this->getRelatedModel();

        return $entry->belongsToMany(
            get_class($model),
            $this->getPivotTableName(),
            'entry_id',
            'related_id'
        )->orderBy($this->getPivotTableName() . '.sort_order', 'ASC');
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
     * Get the pre-defined handlers.
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Return the input view.
     *
     * @return string
     */
    public function getInputView()
    {
        return 'anomaly.field_type.multiple::' . $this->config('mode');
    }

    /**
     * Get the related model.
     *
     * @return null|EntryInterface
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
