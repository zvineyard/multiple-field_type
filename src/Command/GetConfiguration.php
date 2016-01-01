<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class GetConfiguration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Command
 */
class GetConfiguration implements SelfHandling
{

    /**
     * The config key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new GetConfiguration instance.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Handle the command.
     *
     * @param Repository $cache
     * @return Collection
     */
    public function handle(Repository $cache)
    {
        return new Collection(
            array_merge($cache->get('anomaly/multiple-field_type::' . $this->key), ['key' => $this->key])
        );
    }
}
