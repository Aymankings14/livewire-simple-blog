<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $title;
    public $category;
    public $body;
    public $image;
    public function render(): Factory|View
    {
        $categories = Category::all();
        return view('livewire.create-post',compact('categories'));
    }
    public function save(){
        $this->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'body' => 'required',
            'image' => 'mimes:jpg,jpeg,gif,png|max:5000'
        ]);
        $data['user_id'] = auth()->id() ? auth()->id(): 1;
        $data['title'] = $this->title;
        $data['body'] = $this->body;
        $data['category_id'] = $this->category;
        if (!empty($this->image)) {
            $image = $this->image;
            $fileName = Str::slug($this->title) . '.' . $image->getClientOriginalExtension();
            $path = public_path('/assets/images/' . $fileName);
            Image::make($image->getRealPath())->save($path, 100);
            $data['image'] = $fileName;
        }
        Post::create($data);
        $this->reset();
        session()->flash('message','Post created successfully');
        redirect('livewire/posts');
    }
    public function return_to_posts(): RedirectResponse|Redirector
    {
        return redirect()->route('index.post');
    }
}
