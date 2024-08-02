<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MyCollection extends ResourceCollection
{
    public function __construct($resource, private string $message, private bool $success, private $extra)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'extra' => $this->extra,
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
