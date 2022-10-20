<?php

namespace App\Models\Snapshots;

abstract class Snapshot
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function __get($name)
    {
        $mutator = \Str::camel('get_' . $name . '_property');

        if (method_exists($this, $mutator)) {
            return $this->{$mutator}();
        }

        return $this->data[$name];
    }

    static public function create(SnapshotableModel $model): self
    {
        return new static($model->snapshot());
    }
}

