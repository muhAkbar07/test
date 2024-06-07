<?php

/**
 * Created by Reliese Model.
 */

 namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Outlet.
 *
 * @property int $id
 * @property string $name
 * @property int $outlet_code
 * @property Collection|Ticket[] $tickets
 */
class Outlet extends Model
{
    public $timestamps = false;
    protected $table = 'outlets';

    protected $fillable = [
        'name',
        'outlet_code', 
        'company_name',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}