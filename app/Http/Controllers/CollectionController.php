<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CollectionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function collectionMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection;
    }

    public function ddMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection->dd();
    }

    public function avgMethod()
    {
        $collection = [1, 2, 3, 4, 5];

        return collect($collection)->avg(); // array_sum($collection)/count($collection);
    }

    public function chunkMethod()
    {
        return collect([1, 2, 3, 4, 5])->chunk(2);
    }

    public function combineMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection->combine(([6, 7, 8, 9, 0]));
    }

    public function containsMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection->contains(5);
    }

    public function countMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection->contains(5);
    }

    public function diffMethod()
    {
        $collection = collect([1, 2, 3, 4, 5]);

        return $collection->combine(([6, 7, 3, 9, 0]));
    }

    public function flipAndForgetMethod()
    {
        $collection = collect([
            'name' => 'Bob',
            'job' => 'Developer',
            'country' => 'India'
        ]);

        return $collection->flip() . $collection->forget('name');
    }

    public function mapWithKeysMethod()
    {
        $collection = collect([
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
            ['id' => 3, 'name' => 'Item 3'],
        ]);

        $newCollection = $collection->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });

        return $newCollection;
    }

    public function usefulMethod()
    {
        // $users = User::latest()->paginate(10);

        // $users->each(function ($value, $key) {
        //     echo $value['name'];
        // });

        // $users->map(function ($item, $key){
        //     echo $item['email'];
        // });

        // $users = User::all();
        // $filtered = $users->filter(function ($value, $key) {
        //     return $value['id'] < 5;
        // });

        // return $filtered->all();
        // return $filtered->pluck('name');

        $users = User::all();
        return $users->pluck('name')->except('id', 30)->forget('Bethany Parker')->skip(29);
    }

    public function macroMethod() {
        $collection = collect(['apple', 'banana', 'strawberry']);
        return $collection->pluralize();
    }
}
