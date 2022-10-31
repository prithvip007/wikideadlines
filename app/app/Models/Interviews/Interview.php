<?php

namespace App\Models\Interviews;

use File;

class Interview
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    protected function getFile(string $path): string {
        return File::get(resource_path() . '/interviews/' . $path);
    }

    public function get(): string {
        return $this->getFile($this->name);
    }

    public function getArray(): array {
        return json_decode($this->get(), true);
    }

    protected function getItemById(array &$question, int $id) {
        foreach ($question['data']['items'] as &$item) {
            if ( $item['id'] === $id) {
                return $item;
            }
        }

        return null;
    }
}
