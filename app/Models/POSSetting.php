<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSSetting extends Model
{
    use HasFactory;

    protected $table = 'pos_settings';

    protected $fillable = [
        'key',
        'value',
    ];
}
