<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType;

/**
 * Class CreatePivotTableCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\FieldType\Multiple\Command
 */
class CreatePivotTableCommand
{

    /**
     * The field type.
     *
     * @var MultipleFieldType
     */
    protected $type;

    /**
     * Create a new CreatePivotTableCommand.
     *
     * @param MultipleFieldType $type
     */
    function __construct(MultipleFieldType $type)
    {
        $this->type = $type;
    }

    /**
     * Get the field type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
 