<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empresa_id',
        'titulo',
        'descripcion',
        'image',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'experiencias';

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

    /**
     * autores
     *
     * @param  mixed $experiencia
     * @param  mixed $empresa
     * @return void
     */
    public function autores($experiencia, $empresa)
    {
        return $this->where([['id', '=', $experiencia], ['empresa_id', '=', $empresa]])->exists();
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterExperiencia($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('titulo', 'like', '%' . $search . '%');
        });
    }
}
