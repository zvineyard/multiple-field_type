<?php namespace Anomaly\MultipleFieldType;

use Anomaly\MultipleFieldType\Command\CreatePivotTable;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreated;
use Illuminate\Foundation\Bus\DispatchesCommands;

class MultipleFieldTypeListener
{

    use DispatchesCommands;

    public function handle(AssignmentWasCreated $event)
    {
        $assignment = $event->getAssignment();

        $type = $assignment->getFieldType();

        if ($type instanceof MultipleFieldType) {
            $this->dispatch(new CreatePivotTable($type));
        }
    }
}
 