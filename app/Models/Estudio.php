<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'graduado',
        'institucion_educativa',
        'programa_academico',
        'year',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'estudios';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEstudio($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('programa_academico', 'like', '%' . $search . '%');
        });
    }
}
