@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary">Create Post</a>
                    <p></p>
                    <h2>Your Blog Posts</h2>
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td style="width:70px"><a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a></td>
                                <td style="width:80px">
                                    <form action="{{ action('PostsController@destroy', $post->id) }}" method="POST" class="float-right">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p>You have no Posts</p>
                    @endif   
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
