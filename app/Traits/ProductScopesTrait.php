<?php

namespace App\Traits;

trait ProductScopesTrait
{

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeSortFilterBy($query, $sortBy = "")
    {
        switch ($sortBy) {
            case 'featured':
                return $query->where('featured', '=', -1);
                break;
            case 'low':
                return $query->orderBy('sale_price', 'asc');
                break;
            case 'high':
                return $query->orderBy('sale_price', 'desc');
                break;
            default:
                return $query;
                break;
        }
    }

    public function scopeFilterAttributes($query, $checkboxValues)
    {
        if ($checkboxValues !== NULL) {
            return $query->whereHas('attributeValues', function ($query) use ($checkboxValues) {
                $query->whereIn('value', $checkboxValues);
            });
        }
        return $query;
    }

    public function scopeSearchProducts($query, $search = "")
    {
        if ($search !== NULL) {
            $searchTerm  = '%' . $search . '%';
            return $query->where('name', 'like', $searchTerm ?? '');
        }
        return $query;
    }

    public function scopeSubcategoriesIds($query, $arrayOfSubcategoryIds = "")
    {
        if ($arrayOfSubcategoryIds !== NULL) {
            return $query->orWhereIn('category_id', $arrayOfSubcategoryIds);
        }
        return $query;
    }
}
