<?php namespace Anomaly\MultipleFieldType;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class MultipleFieldTypeSchema
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
     * Create the pivot table.
     *
     * @param $table
     */
    public function createPivotTable($table, $foreignKey, $otherKey)
    {
        $this->schema->dropIfExists($table);

        $this->schema->create(
            $table,
            function (Blueprint $table) use ($foreignKey, $otherKey) {

                $table->increments('id');
                $table->integer($foreignKey);
                $table->integer($otherKey);
            }
        );
    }

    /**
     * Drop the pivot table.
     *
     * @param $table
     */
    public function dropPivotTable($table)
    {
        $this->schema->dropIfExists($table);
    }
}
