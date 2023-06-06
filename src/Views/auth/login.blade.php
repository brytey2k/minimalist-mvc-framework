@extends('layouts.app')

@section('content')
    <div class="col-md-12 comment-form">
        <form action="/process-login" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username..." id="username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password..." id="password">
            </div>

            <div>
                <input type="submit" value="Login" name="login">
            </div>
        </form>
    </div>
@endsection