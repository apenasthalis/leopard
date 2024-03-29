<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $table = 'daily_summary';
    public $timestamps = false;



    protected $fillable = [
        'id',
        'id_employee',
        'date',
        'summary'
    ];
 
}
