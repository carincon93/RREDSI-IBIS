<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'numero_celular',
        'numero_documento',
        'email',
        'autorizacion_datos',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'empresas';

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEmpresa($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
