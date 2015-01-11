<?php namespace Anomaly\MultipleFieldType\Command\Handler;

use Anomaly\MultipleFieldType\Command\CreatePivotTable;
use Anomaly\MultipleFieldType\MultipleFieldTypeSchema;

/**
 * Class CreatePivotTableHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Command
 */
class CreatePivotTableHandler
{

    /**
     * The schema builder.
     *
     * @var \Anomaly\MultipleFieldType\MultipleFieldTypeSchema
     */
    protected $schema;

    /**
     * Create a new CreatePivotTableHandler instance.
     *
     * @param MultipleFieldTypeSchema $schema
     */
    function __construct(MultipleFieldTypeSchema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Handle the command.
     *
     * @param CreatePivotTable $command
     */
    public function handle(CreatePivotTable $command)
    {
        $type = $command->getType();

        $this->schema->createPivotTable($type->getPivotTable(), $type->getForeignKey(), $type->getRelatedKey());
    }
}
