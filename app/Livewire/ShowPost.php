<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;

class ShowPost extends Component
{
    public int $post_id;
    public  $post;
    public string $title;
    public string $category;
    public string $user;
    public string $body;
    public  $image;

    public function mount(){
        $this->post_id = request()->post_id;
        $this->post = Post::with(['user','category'])->find($this->post_id);
        $this->title =$this->post->title;
        $this->body =$this->post->body;
        $this->category =$this->post->category->name;
        $this->user=$this->post->user->name;
        $this->image =$this->post->image;
    }
    public function render()
    {
        return view('livewire.show-post',[
            'post'=>$this->post
        ]);
    }
    public function return_to_posts(){
        return redirect()->route('index.post');
    }
}
