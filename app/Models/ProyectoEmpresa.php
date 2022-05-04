<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoEmpresa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empresa_id',
        'proyecto_id',
        'activo',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'proyecto_empresa';

    public function proyectos()
    {
        return $this->belongsTo(Proyecto::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];
}
