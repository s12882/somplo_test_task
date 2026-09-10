<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['phone_name', 'seller_id', 'display_size', 'quantity', 'cost'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * Attributes to cast
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'display_size' => 'decimal:1',
            'cost' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    /**
     * Seller who owns this product
     * @return BelongsTo<Seller, $this>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
