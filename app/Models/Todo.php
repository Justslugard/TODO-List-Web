<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = "todo_list";

    protected $fillable = ["title", "status"];
}
