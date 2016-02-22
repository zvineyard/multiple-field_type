<?php namespace Anomaly\MultipleFieldType\Table;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class LookupTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Table
 */
class LookupTableBuilder extends TableBuilder
{

    /**
     * The field type configuration.
     *
     * @var null|Collection
     */
    protected $config = null;

    /**
     * The ajax flag.
     *
     * @var bool
     */
    protected $ajax = true;

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [
        'enable_views' => false,
        'title'        => 'anomaly.field_type.multiple::message.select_entries'
    ];

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
}
