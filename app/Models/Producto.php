<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
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
        'image',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'productos';

    public function autores($producto, $empresa)
    {
        return $this->where([['id', '=', $producto], ['empresa_id', '=', $empresa]])->exists();
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterProducto($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
