<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubareaConocimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_conocimiento_id',
        'nombre',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'subareas_conocimiento';

    public function areaConocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class);
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->hasMany(DisciplinaSubareaConocimiento::class);
    }
}
