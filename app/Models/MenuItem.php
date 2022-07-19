<?php


namespace App\Models;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public function menus()
    {
        return $this->hasMany(MenuItem::class,'parent_id');
    }
}
