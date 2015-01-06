<?php namespace Anomaly\MultipleFieldType;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Laracasts\Commander\CommanderTrait;

class MultipleFieldTypeListener
{

    use CommanderTrait;

    public function handle(AssignmentCreatedEvent $event)
    {
        $assignment = $event->getAssignment();

        $type = $assignment->getFieldType();

        if ($type instanceof MultipleFieldType) {

            $this->execute(
                'Anomaly\Streams\Addon\FieldType\Multiple\Command\CreatePivotTableCommand',
                compact('type')
            );
        }
    }
}
 