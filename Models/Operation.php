<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    //use HasFactory;
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $fillable = ['type_operation','montant','id_compte'];
}
