<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'loans_id', 'goods_id', 'entries_id', 'qty'
    ];

    protected $hidden = [];

    public function good_entry()
    {
        return $this->belongsTo(GoodEntry::class, 'goods_id', 'id');
    }

    public function good_loan()
    {
        return $this->belongsTo(GoodLoan::class, 'loans_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // $warehouse = LoanDetail::with('good_entry')
            //     ->where('entries_id', 'good_entry->rooms_id')
            //     ->where('status', 'DIPINJAM')
            //     ->whereNull('date_return')
            //     ->get();

            // if ($warehouse) {
            //     $model->good_entry->last_stock = $model->good_entry->stock - (int) $model->qty;
            //     $model->good_entry->stock = $model->good_entry->last_stock;
            //     $model->good_entry->save();
            // }
        });

        // static::updating(function ($model) {
        //     $return = LoanDetail::with('good_entry')
        //         ->where('entries_id', 'good_entry->rooms_id')
        //         ->where('status', 'DIKEMBALIKAN')
        //         ->whereNotNull('date_return')
        //         ->get();

        //     if ($return) {
        //         $model->good_entry->last_stock = $model->good_entry->stock + (int) $model->qty;
        //         $model->good_entry->stock = $model->good_entry->last_stock;
        //         $model->good_entry->save();
        //     }
        // });
    }
}
