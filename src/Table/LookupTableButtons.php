<?php namespace Anomaly\MultipleFieldType\Table;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LookupTableButtons
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Table
 */
class LookupTableButtons implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param LookupTableBuilder $builder
     */
    public function handle(LookupTableBuilder $builder)
    {
        $builder->setButtons(
            [
                'add' => [
                    'data-entry' => 'entry.id',
                    'data-key'   => $builder->config('key')
                ]
            ]
        );
    }
}
