
<form action="{{ route('users.search') }}" method="GET">
    <input type="text" name="search" placeholder="Search Products" value="">
    <button type="submit">Search</button>
    {{csrf_field()}}
</form>
 
<div class="container-fluid px-4">
    <h1 class="mt-4">Users</h1>
    <div class="row">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">There are no users.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
