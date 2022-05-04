<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institucion_educativa_id',
        'nombre',
        'email',
        'numero_telefono',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'facultades';

    public function institucionEducativa()
    {
        return $this->belongsTo(InstitucionEducativa::class);
    }

    public function programasAcademicos()
    {
        return $this->hasMany(ProgramaAcademico::class);
    }

    public function gruposInvestigacion()
    {
        return $this->hasMany(GrupoInvestigacion::class);
    }

    public function ambientesFormacion()
    {
        return $this->hasMany(AmbienteFormacion::class);
    }

    public function equiposFormacion()
    {
        return $this->hasMany(EquipoFormacion::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class, 'miembros_facultad', 'facultad_id', 'user_id')
            ->withPivot([
                'principal'
            ]);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterFacultad($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
