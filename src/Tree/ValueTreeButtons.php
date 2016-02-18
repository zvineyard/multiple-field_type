<?php namespace Anomaly\MultipleFieldType\Tree;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ValueTreeButtons
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\MultipleFieldType\Tree
 */
class ValueTreeButtons implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param ValueTreeBuilder $builder
     */
    public function handle(ValueTreeBuilder $builder)
    {
        $builder->setButtons(
            [
                'remove' => [
                    'data-dismiss' => 'multiple',
                    'data-entry'   => 'entry.id'
                ]
            ]
        );
    }
}
