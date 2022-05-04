<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tipo_solicitud',
        'estado',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'solicitudes';

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
