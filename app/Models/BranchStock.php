<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchStock extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'item_id',
        'quantity',
        'branch_id',
    ];
}
