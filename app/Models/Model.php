<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquenModel;

class Model extends EloquenModel
{
    public function scopeRecent($query) {
        return $query->orderBy('id', 'desc');
    }

    public function scropeOrdered($query) {
        return $query->orderBy('order', 'desc');
    }
}
