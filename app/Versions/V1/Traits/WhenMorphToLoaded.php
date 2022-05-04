<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait WhenMorphToLoaded
{
    public function whenMorphToLoaded($name, $map)
    {
        return $this->whenLoaded($name, function () use ($name, $map) {
            $morphType = $name . '_type';
            $morphAlias = $this->resource->$morphType;
            $morphClass = Relation::getMorphedModel($morphAlias);
            $morphResourceClass = $map[$morphClass];
            return new $morphResourceClass($this->resource->$name);
        });
    }
}
