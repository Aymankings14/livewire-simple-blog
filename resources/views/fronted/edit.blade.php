@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <b> Update Posts</b>
                    <a href="{{route('posts.index')}}" class="btn btn-primary btn-sm ms-auto" >Back</a>
                </div>
                <div class="card-body">
                    <form action="{{route('posts.update',$post->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" name="title" value="{{old('title',$post->title)}}" class="form-control">
                            @error('title') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category"  class="form-select ">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{old('category',$post->category_id) == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea id="body"  name="body" class="form-control" rows="5">{{old('body',$post->body)}}</textarea>
                            @error('body') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        @if($post->image !== '')
                        <div class="form-group">
                            <img src="{{asset('assets/images/'.$post->image)}}" alt="{{$post->title}}" width="100">
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="image">image</label>
                            <input id="image" type="file" name="image" class="form-control">
                            @error('image') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="text-center">
                            <input type="submit" value="update Post" name="save" class=" btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
