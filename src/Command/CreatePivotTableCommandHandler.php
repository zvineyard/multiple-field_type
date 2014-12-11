<?php namespace Anomaly\Streams\Addon\FieldType\Multiple\Command;

use Anomaly\Streams\Addon\FieldType\Multiple\MultipleFieldTypeSchema;

class CreatePivotTableCommandHandler
{

    protected $schema;

    function __construct(MultipleFieldTypeSchema $schema)
    {
        $this->schema = $schema;
    }

    public function handle(CreatePivotTableCommand $command)
    {
        $type = $command->getType();

        $this->schema->createPivotTable($type->getPivotTable(), $type->getForeignKey(), $type->getRelatedKey());
    }
}
 