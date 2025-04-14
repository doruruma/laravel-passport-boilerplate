<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = "logs";

    protected $fillable = [
        "user_id",
        "operation",
        "table_name",
        "record_id",
        "old_data",
        "new_data",
    ];
}
