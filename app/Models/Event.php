<?php

namespace App\Models;

use App\Models\workshop;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function workshops() {
        return $this->hasMany(Workshop::class);

        // return $this->hasMany(Workshop::class)->ofMany([
        //     'start' => 'max'
        // ], function ($query) {
        //     $query->where('start', '>', '2021-02-21 10:37:45');
        // });
    }
}
