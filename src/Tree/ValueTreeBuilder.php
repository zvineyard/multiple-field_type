<?php namespace Anomaly\MultipleFieldType\Tree;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class ValueTreeBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Tree
 */
class ValueTreeBuilder extends TreeBuilder
{

    /**
     * The field type configuration.
     *
     * @var null|Collection
     */
    protected $config = null;

    /**
     * The field type.
     *
     * @var null|MultipleFieldType
     */
    protected $fieldType = null;

    /**
     * The selected entry.
     *
     * @var array
     */
    protected $selected = [];

    /**
     * The tree options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Fired just before querying.
     *
     * @param Builder $query
     */
    public function onQuerying(Builder $query)
    {
        $uploaded = $this->getSelected();

        if ($fieldType = $this->getFieldType()) {

            /**
             * If we have the entry available then
             * we can determine saved sort order.
             */
            $entry   = $fieldType->getEntry();
            $table   = $fieldType->getPivotTableName();
            $related = $fieldType->getRelatedModel();

            $query->join($table, $table . '.related_id', '=', $related->getTableName() . '.id');
            $query->where($table . '.entry_id', $entry->getId());
            $query->orderBy($table . '.sort_order', 'ASC');
        } else {

            /**
             * If all we have is ID then just use that.
             * The JS / UI will be handling the sort
             * order at this time.
             */
            $query->whereIn('id', $uploaded ?: [0]);
        }
    }

    /**
     * Return a config value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    /**
     * Get the config.
     *
     * @return Collection|null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the config.
     *
     * @param Collection $config
     * @return $this
     */
    public function setConfig(Collection $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the selected value.
     *
     * @return array
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Get the selected value.
     *
     * @param array $selected
     * @return $this
     */
    public function setSelected(array $selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Get the field type.
     *
     * @return MultipleFieldType|null
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set the field type.
     *
     * @param MultipleFieldType $fieldType
     * @return $this
     */
    public function setFieldType(MultipleFieldType $fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Set the tree entries.
     *
     * @param \Illuminate\Support\Collection $entries
     * @return $this
     */
    public function setTreeEntries(\Illuminate\Support\Collection $entries)
    {
        if (!$this->getFieldType()) {
            $entries = $entries->sort(
                function ($a, $b) {
                    return array_search($a->id, $this->getSelected()) - array_search($b->id, $this->getSelected());
                }
            );
        }

        return parent::setTreeEntries($entries);
    }
}
