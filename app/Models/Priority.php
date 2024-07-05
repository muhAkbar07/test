<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority.
 *
 * @property int $id
 * @property string $name
 * @property int $sla_hours
 * @property Collection|Ticket[] $tickets
 */
class Priority extends Model
{   
    
    public $timestamps = false;
    protected $table = 'priorities';

    protected $fillable = [
        'name',
        'sla_hours',
        'description',
        'is_active',
        'created_at',
    ];

    const HIGH = 1;
    const MEDIUM = 2;
    const LOW = 3;

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    
}