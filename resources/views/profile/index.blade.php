@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('products.index') }}">
                <button class="btn btn-primary">
                    back
                </button>
            </a>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ Auth::user()->email }}</td>
                        <td>{{ Auth::user()->isAdmin ? 'Admin' : 'User' }}</td>
                        <td>
                            <a href="{{ route('profile.edit', Auth::user()) }}">
                                <button class="btn btn-primary">
                                    Edit
                                </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection