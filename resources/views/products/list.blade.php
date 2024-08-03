@extends('products.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Laravel 11 CRUD Example from scratch - ItSolutionStuff.com</h2>
    <div class="card-body">

        @session('success')
        <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '' }}</td>
                    <td>{{ $product->details }}</td>
                    <td>
                        <form action="" method="POST">
                            <a class="btn btn-info btn-sm" href=""><i class="fa-solid fa-list"></i> Show</a>
                            <a class="btn btn-primary btn-sm" href=""><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">There are no data.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

        {!! $products->links() !!}

    </div>
</div>
@endsection