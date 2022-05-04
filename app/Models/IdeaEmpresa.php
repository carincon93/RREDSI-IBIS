<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaEmpresa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'tipo',
        'tiene_equipos',
        'equipos',
        'tiene_recursos',
        'recursos',
        'condicion',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'ideas_empresa';

    public function user()
    {
        return $this->hasOne(User::class, 'nit_empresa');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function autores($idea, $empresa)
    {
        return $this->where([['id', '=', $idea], ['empresa_id', '=', $empresa]])->exists();
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    public function ispublic($idea, $empresa)
    {
        return $this->where([['id', '=', $idea], ['es_publica', '=', true]])->exists();
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterIdeaEmpresa($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
