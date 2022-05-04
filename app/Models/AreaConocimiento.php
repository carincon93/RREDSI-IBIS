<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaConocimiento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'areas_conocimiento';

    public function trabajosGrado()
    {
        return $this->hasMany(TrabajoGrado::class);
    }

    public function subareasConocimiento()
    {
        return $this->hasMany(SubareaConocimiento::class);
    }
}
