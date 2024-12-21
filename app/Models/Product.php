<?php

namespace App\Models;

use App\Service\PriceGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'characteristics',
        'company_id',
        'category_id',
        'price',
        'images',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'characteristics' => 'array',
        'company_id' => 'integer',
        'category_id' => 'integer',
        'images' => 'array',
    ];

    protected $with = ['discount'];

    protected $appends = ['price_discount'];

    protected function priceDiscount(): Attribute
    {
        return new Attribute(
            get: function() {
                if ($price = PriceGenerator::calculatePrice($this)) {
                    if ($price != false) {
                        return number_format($price, 2);
                    }
                }
            },
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discount(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'product_discount')
            ->where('status', '=', 1);
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'product_discount');
    }
}
