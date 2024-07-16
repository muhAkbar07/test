<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini diimpor
use Illuminate\Database\Eloquent\Model;

/**
 * Class Outlet
 *
 * @property int $id
 * @property string $name
 * @property int $outlet_code
 * @property string $company_name
 * @property Collection|Ticket[] $tickets
 */
class Outlet extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'outlets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at'; // Ini juga perlu ditambahkan jika ada kolom updated_at

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