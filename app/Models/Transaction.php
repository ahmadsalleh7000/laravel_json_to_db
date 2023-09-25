<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount', 'currency', 'email', 'statusCode', 'paymentDate', 'parentIdentification','provider'
    ];

    // Define the accessor for 'status'
    public function getStatusAttribute()
    {
        $statusCodes = [
            1   => 'authorized',
            2   => 'decline',
            3   => 'refunded',
            100 => 'authorized',
            200 => 'decline',
            300 => 'refunded',
        ];

        return $statusCodes[$this->statusCode] ?? 'Unknown';
    }

    
    public function scopeFilterByStatus($query, $statusString)
    {
        // Map the status string to its corresponding numeric code
        $statusCodes = [
            'authorized' => [1, 100],
            'decline'    => [2, 200],
            'refunded'   => [3, 300],
        ];

        // Check if the provided status string is valid
        if (array_key_exists($statusString, $statusCodes)) {
            $statusCode = $statusCodes[$statusString];
        } else {
            // Handle the case where the status string is invalid
            return $query;
        }

        // Add the whereIn condition to the query builder
        return $query->whereIn('statusCode', $statusCode);
    }

    public function scopeRangeMin($query, $balanceMin)
    {
        // Add the where condition to the query builder
        return $query->where('amount',">=",$balanceMin);
    }

    public function scopeRangeMax($query, $balanceMax)
    {
        // Add the where condition to the query builder
        return $query->where('amount',"<=", $balanceMax);
    }

    public function scopeCurrency($query, $currency)
    {
        // Add a where condition to the query builder to filter by currency (case-insensitive)
        return $query->whereRaw('LOWER(currency) = ?', [strtolower($currency)]);
    }
}
