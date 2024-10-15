<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Note;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Scopes\UserStatusScope;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function users(Request $request)
    {
        DB::enableQueryLog();

        // Get all Users
        // $users = User::get();

        // Get users based on Query param 'search'
        if(!empty($request->input('search'))) {

            $search = $request->input('search');
            $users = User::where('name', 'like', "%$search%")->get();

            $users = User::query()->when(
                $request->search,
                function (Builder $builder) use ($request) {
                    $builder->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                }
            )->paginate(5);
        }

        // whereTime method with query builder
        // $users = DB::table('users')->whereTime('created_at', '=', '09:59:29')->get();

        // whereTime method with eloquent model
        // $users = User::whereTime('created_at', '09:59:29')->get();

        // where Clause Condition with query builder
        // $users = User::whereBetween('created_at', ['2024-08-07 00:00:00', '2024-08-08 23:59:59'])->get();

        // Orderby with Limit
        // $users = User::orderBy('name', 'asc')->limit(5)->get();

        // orderByRaw & orderByDesc
        // $users = User::select("*")->where("status", 1)->orderByDesc("name")->get();

        // fetching all active and non-deleted users
        // $users = User::all();

        // fetch all users weather they are active or not
        // $users = User::withoutGlobalScope(new UserStatusScope)->get();

        // apply delete local scope to following query
        // $users = User::status(0)->orderBy('created_at')->get();

        // $superUser = [
        //     'name' => 'balakarthikeyan', 
        //     'email' => 'balakarthikeyan00@gmail.com',
        //     'password' => Hash::make('12345678')
        // ];

        // DB::beginTransaction();
        // try {
        //     $users = User::create($superUser);
        //     DB::commit();
        //     return $this->setStatusCode(201)->respondWithSuccess($users, 'Message of Success');
        // } catch (\Exception $ex) {
        //     return ApiResponseClass::rollback($ex);
        // }

        // Create notes for a user
        // $users = User::find(11);
        // $post = new Note(['title' => 'New Post Title', 'content' => 'Post content.']);
        // $users->notes()->save($post);

        // Retrieving notes for a user
        // $notes = $users->notes;

        // Retrieving the user for a notes:
        // $note = Note::find(1);
        // $users = $note->user;

        // Create a user with a profile
        // $users = new User($superUser);
        // $users->save();
        // $profile = new Profile(['bio' => 'A brief bio']);
        // $users->profile()->save($profile);

        // Retrieving the user profile:
        // $profile = Profile::find(1);
        // $users = $profile->user;

        // Orderby Belongs to Relationship
        // $users = User::with(['profile' => function ($q){
        //     $q->orderBy('user_id', 'DESC');
        // }])->get();

        $users = User::with(['notes', 'profile'])->get();

        // $users = User::emailVerified()->status(1)->get();
        // $users = User::emailVerified()->orWhere(function (Builder $query) {
        //     $query->status(1);
        // })->get();

        // $users = User::ofRole('admin')->get();

        Log::debug(DB::getQueryLog());

        return $this->setStatusCode(201)->respondWithSuccess($users, 'Message of Success');
        // return view('user.list', compact('users'));
    }

    /**
     * Display a listing of the resource.
     */
    public function notes(Request $request)
    {
        $notes = Note::all();

        // $user = User::find(1);
        // $user->settings = ['theme' => 'dark', 'notifications' => true];
        // $user->save();
        // // Accessing the attribute
        // $settings = $user->settings; // ['theme' => 'dark', 'notifications' => true]

        /*
        // scope
        // $notes = Note::status('pending')->get(['id', 'title', 'content']);

        // global scope
        // $notes = Note::withoutGlobalScope(ActiveScope::class)->get();

        $notes = Note::find(1);	
        $tag = new Tag;
        $tag->name = "Laravel";
        $notes->tags()->save($tag);

        $product = Product::find(1);	
        $tag1 = new Tag;
        $tag1->name = "Laravel";
        $tag2 = new Tag;
        $tag2->name = "jQuery";
        $product->tags()->saveMany([$tag1, $tag2]);

        // Attaching a product from a course
        $product->tags()->attach([$tag1->id, $tag2->id]);
        $product->tags()->sync([$tag1->id, $tag2->id]);
        // Detaching a product from a course
        $product->tags()->detach($tag->id);
        // Retrieving all courses for a product
        $productTags = $product->tag;
        */

        return $notes;
    }

    /**
     * Display a listing of the resource.
     */
    public function products(Request $request)
    {

        $data = [
            'name' => 'Product 1',
            'details' => 'What Are JSON Fields',
            'category_id' => 1,
            'specs' => ['tags' => ['biscuit', 'chocolate', 'milk']],
        ];

        DB::beginTransaction();
        try {
            $product = Product::create($data);
            // $product = new ProductResource($product);


            // $product = Product::whereJsonContains('details->tags', 'chocolate')->get();


            // $product = Product::find(3);
            // $details = $product->details;
            // $details['tags'][] = 'cashew';
            // $product->details = $details;
            // $product->update();

            // $product = Product::find(3);
            // $details = $product->details;
            // unset($details['tags']);
            // $product->details = $details;
            // $product->save();

            // $product = Product::create([
            //     'name' => 'Platinum 1',
            //     'price' => 10
            // ]);

            // $post = Post::create(['title' => 'New Post', 'content' => 'Post content']);

            // $users = DB::table('users')->whereJsonContains('preferences->notifications', 'email')->get();
            // $input = [
            // 'name' => 'Gold',
            // 'body' => 'This is a Gold',
            // 'status' => ProductStatus::Active
            // ];

            // $product = Product::create($input);

            // dd($product->status, $product->status->value);

            // $users = DB::table('users')->select("*")->orderByRaw("concat(first_name, ' ', last_name) DESC")->get();

            DB::commit();
            return $this->setStatusCode(201)->respondWithSuccess($product, 'Message of Success');
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
