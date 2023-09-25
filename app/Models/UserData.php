<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'balance', 'currency', 'email', 'created_at', 'id'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'email', 'email');
    }

    // Mutator to format the date before saving to the database
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }


    // Accessor to format the date when retrieving from the database
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
