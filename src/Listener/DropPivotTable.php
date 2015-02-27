<?php namespace Anomaly\MultipleFieldType\Listener;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Illuminate\Database\Schema\Builder;

/**
 * Class DropPivotTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\MultipleFieldType\Listener
 */
class DropPivotTable
{

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamSchema instance.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Handle the event.
     *
     * @param AssignmentWasDeleted $event
     */
    public function handle(AssignmentWasDeleted $event)
    {
        $assignment = $event->getAssignment();

        $fieldType = $assignment->getFieldType();

        if (!$fieldType instanceof MultipleFieldType) {
            return;
        }

        $this->schema->dropIfExists($fieldType->getPivotTableName());
    }
}
