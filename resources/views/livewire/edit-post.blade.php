<div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <b> Edit Post</b>
                    <a href="{{route('index.post')}}" wire:navigate class="btn btn-primary btn-sm ms-auto" >Posts</a>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent= "update" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" name="title" wire:model="title" class="form-control">
                            @error('title') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category"  wire:model="category" class="form-select ">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea id="body"  name="body" class="form-control" rows="5" wire:model="body"></textarea>
                            @error('body') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        @if($this->image_orignal != '')
                            <div class="form-group">
                                <img src="{{asset('assets/images/'.$this->image_orignal)}}" alt="{{$this->title}}" width="120">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="image">image</label>
                            <input id="image" type="file" name="image" class="form-control" wire:model="image">
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
</div>
