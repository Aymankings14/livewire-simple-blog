<div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <b>Posts</b>
                    <a href="{{route('postCreate')}}" wire:navigate class="btn btn-primary btn-sm ms-auto" >Create</a>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert" id="alert-session">
                                {{session('message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                    @endif
                        @if(session()->has('message_error'))
                            <div class="alert alert-danger alert-dismissible" role="alert" id="alert-session">
                                {{session('message_error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr class>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Owner</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td><img src="{{asset('assets/images/'.$post->image)}}" alt="{{$post->title}}" width="100"></td>
                                    <td>
                                        <a href="{{route('postShow',$post->id)}}" wire:navigate class="nav-link text-primary-emphasis">{{$post->title}}</a>
                                    </td>
                                    <td>{{$post->user->name}}</td>
                                    <td>{{$post->category->name}}</td>
                                    <td>
                                        <a href="{{route('postEdit',$post->id)}}" wire:navigate class="btn btn-primary btn-sm">Edit</a>
                                        <a href="javascript:void(0);" wire:click="delete_post({{$post->id}})" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?');return false;">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>not found record's in your database</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
