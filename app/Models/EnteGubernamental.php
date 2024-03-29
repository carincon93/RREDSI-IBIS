<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnteGubernamental extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'entidad_Gubernamental';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'direction',
        'phone',
        'nit',
        'city',
        'id_delegado_entidad'

    ];

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
     * Relationship with FirstRelatedModel
     *
     * @return void
     */
    public function firstRelatedModel()
    {
        return $this->belongsTo(FirstRelatedModel::class);
    }

    /**
     * Relationship with SecondRelatedModel
     *
     * @return void
     */
    public function secondRelatedModel()
    {
        return $this->hasOne(SecondRelatedModel::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEnteGubernamental($query, array $filters)
    {
        // En el where reemplazar 'Nombre columna' por el nombre de la columna a filtrar
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('Nombre columna', 'ilike', '%'.$search.'%');
        });
    }
}
