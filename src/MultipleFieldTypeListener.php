<?php namespace Anomaly\MultipleFieldType;

use Anomaly\MultipleFieldType\Command\CreatePivotTableCommand;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Illuminate\Foundation\Bus\DispatchesCommands;

class MultipleFieldTypeListener
{

    use DispatchesCommands;

    public function handle(AssignmentCreatedEvent $event)
    {
        $assignment = $event->getAssignment();

        $type = $assignment->getFieldType();

        if ($type instanceof MultipleFieldType) {
            $this->dispatch(new CreatePivotTableCommand($type));
        }
    }
}
 