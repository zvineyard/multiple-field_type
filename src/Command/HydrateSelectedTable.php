<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\Table\SelectedTableBuilder;
use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class HydrateSelectedTable
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Command
 */
class HydrateSelectedTable implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The value table.
     *
     * @var SelectedTableBuilder
     */
    protected $table;

    /**
     * Create a new HydrateSelectedTable instance.
     *
     * @param SelectedTableBuilder $table
     */
    public function __construct(SelectedTableBuilder $table)
    {
        $this->table = $table;
    }

    /**
     * Handle the command.
     *
     * @param Hydrator $hydrator
     */
    public function handle(Hydrator $hydrator)
    {
        if (!$definition = $this->dispatch(new GetSelectedDefinition($this->table))) {
            return;
        }

        $hydrator->hydrate($this->table, $definition);
    }
}
