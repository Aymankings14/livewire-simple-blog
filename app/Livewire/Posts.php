<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use withPagination;
    public function render()
    {
        return view('livewire.posts', [
            'posts' => Post::with(['category','user'])->orderBy('id','desc')->paginate(5),
        ]);
    }

    public function create_post()
    {
        return redirect()->route('postCreate');
    }

    public function show_post($id)
    {
        return redirect()->route('postShow',$id);
    }

    public function edit_post($id)
    {
        $post = Post::where('user_id',auth()->id())->find($id);
        if ($post) {
            return redirect()->route('postEdit', $id);
        }
        session()->flash('message_error','you can not update not yours');
        return redirect()->route('index.post');
    }

    public function delete_post($id)
    {
        $post = Post::where('user_id',auth()->id())->find($id);
        if ($post) {
            if (File::exists('assets/images/'.$post->image)){
                unlink('assets/images/'.$post->image);
            }
            $post->delete();
            session()->flash('message','Post Deleted successfully');
            return redirect()->route('index.post');
        }
        session()->flash('message_error','you can not delete not yours');
        return redirect()->route('index.post');
    }
}
