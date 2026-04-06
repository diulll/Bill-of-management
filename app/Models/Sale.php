<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = ['sale_date', 'notes'];

    protected $casts = [
        'sale_date' => 'date',
    ];

    /**
     * Relasi ke detail item penjualan
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Hitung total menu terjual di sesi ini
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Hitung akumulasi penggunaan bahan baku untuk sale ini
     */
    public function getIngredientUsage(): \Illuminate\Support\Collection
    {
        return \DB::table('sale_items as si')
            ->join('menu_ingredients as mi', 'si.menu_id', '=', 'mi.menu_id')
            ->join('ingredients as i', 'mi.ingredient_id', '=', 'i.id')
            ->where('si.sale_id', $this->id)
            ->select(
                'i.id',
                'i.name',
                'i.unit',
                \DB::raw('SUM(si.quantity * mi.quantity) as total_used')
            )
            ->groupBy('i.id', 'i.name', 'i.unit')
            ->orderByDesc('total_used')
            ->get();
    }
}
