<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProyecto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'tipos_proyecto';

    public function proyecto()
    {
        return $this->hasMany(Proyecto::class);
    }
}
