<?php namespace Anomaly\Streams\Addon\FieldType\Multiple;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

class MultipleFieldTypeListener extends EventListener
{

    use CommanderTrait;

    public function whenAssignmentCreated(AssignmentCreatedEvent $event)
    {
        $assignment = $event->getAssignment();

        $type   = $assignment->getFieldType();

        if ($type instanceof MultipleFieldType) {

            $this->execute(
                'Anomaly\Streams\Addon\FieldType\Multiple\Command\CreatePivotTableCommand',
                compact('type')
            );
        }
    }
}
 