<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['can', 'can_by_user', 'nodo_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empresa_id',
        'institucion_educativa_id',
        'name',
        'email',
        'password',
        'tipo_documento',
        'numero_documento',
        'numero_celular',
        'intereses',
        'perfil',
        'cvlac',
        'esta_habilitado',
        'autorizacion_tratamiento_datos'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function esAdminNodo()
    // {
    //     return $this->hasOne(Nodo::class, 'administrador_id');
    // }

    // public function esAdminInstitucionEducativa()
    // {
    //     return $this->hasOne(InstitucionEducativa::class, 'administrador_id');
    // }

    // public function esEstudianteLider()
    // {
    //     return $this->hasOne(SemilleroInvestigacion::class, 'estudiante_lider_id');
    // }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function institucionEducativa()
    {
        return $this->belongsTo(InstitucionEducativa::class);
    }

    public function estudios()
    {
        return $this->hasMany(Estudio::class);
    }

    public function convocatorias()
    {
        return $this->belongsTo(Convocatoria::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'autores', 'user_id', 'proyecto_id');
    }

    public function semillerosInvestigacion()
    {
        return $this->belongsToMany(SemilleroInvestigacion::class, 'semillero_user', 'user_id', 'semillero_investigacion_id')
            ->withPivot([
                'comentario',
                'aceptado_en',
                'retirado_en',
                'externo',
                'carta_autorizacion',
            ]);
    }

    public function primerPonente()
    {
        return $this->hasOne(ProyectoEventoRredsiDepartamental::class, 'primer_ponente_id');
    }

    public function segundoPonente()
    {
        return $this->hasOne(ProyectoEventoRredsiDepartamental::class, 'segundo_ponente_id');
    }

    public function delegadoInstitucionEducativa()
    {
        return $this->hasOne(InstitucionEducativa::class);
    }

    public function facultades()
    {
        return $this->belongsToMany(Facultad::class, 'miembros_facultad', 'user_id', 'facultad_id')
            ->withPivot([
                'principal'
            ]);
    }

    /**
     * makePassword
     *
     * @param  mixed $numeroDocumento
     * @return void
     */
    public static function makePassword($numeroDocumento)
    {
        return bcrypt("$numeroDocumento*");
    }

    /**
     * getCanAttribute
     *
     * @return void
     */
    public function getCanAttribute()
    {
        return $this->getAllPermissions()->map(function ($t) {
            return ['id' => $t['id']];
        })->pluck('id');
    }

    /**
     * getNodoIdAttribute
     *
     * @return void
     */
    public function getNodoIdAttribute()
    {
        return $this->institucionEducativa ? $this->institucionEducativa->nodo_id : null;
    }

    /**
     * getPermissionsByUserAttribute
     *
     * @return void
     */
    public function getCanByUserAttribute()
    {
        return DB::table('model_has_permissions')->select('permission_id')->where('model_id', $this->id)->get()->pluck('permission_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterUser($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $search = str_replace('"', "", $search);
            $search = str_replace("'", "", $search);
            $search = str_replace(' ', '%%', $search);
            $query->whereRaw("name like '%" . $search . "%'");
        });
    }
}
