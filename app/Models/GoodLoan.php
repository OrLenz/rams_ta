<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodLoan extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'rooms_id', 'borrower_name',
        'date_borrow', 'date_return', 'status', 'slug'
    ];

    protected $hidden = [];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(LoanDetail::class, 'loans_id', 'id');
    }
}
