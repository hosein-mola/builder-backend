<?php

namespace App\Collections;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ComponentCollection extends Collection
{
    public function repack() {
        return collect($this->items)->map(function($item){
            $item['extraAttributes'] = $item[$item['type']];
            return collect($item)->reject(function ($value,$key) use($item) {
                return $value === null || $key == $item['type'];
            });
        });
    }
}
