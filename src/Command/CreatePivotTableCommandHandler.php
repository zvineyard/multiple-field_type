<?php namespace Anomaly\MultipleFieldType\Command;

use Anomaly\MultipleFieldType\MultipleFieldTypeSchema;

/**
 * Class CreatePivotTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Command
 */
class CreatePivotTableCommandHandler
{

    /**
     * The schema builder.
     *
     * @var \Anomaly\MultipleFieldType\MultipleFieldTypeSchema
     */
    protected $schema;

    /**
     * Create a new CreatePivotTableCommandHandler instance.
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
     * @param CreatePivotTableCommand $command
     */
    public function handle(CreatePivotTableCommand $command)
    {
        $type = $command->getType();

        $this->schema->createPivotTable($type->getPivotTable(), $type->getForeignKey(), $type->getRelatedKey());
    }
}
