<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public int $post_id;
    public  $post;
    public string $title;
    public string $category;
    public string $body;
    public  $image;
    public  $image_orignal;

    public function mount(){
        $this->post_id = request()->post_id;
        $this->post = Post::where('user_id',auth()->id())->find($this->post_id) ;
        if (!$this->post){
            session()->flash('message_error','You Can not update not yours');
            return redirect()->route('index.post');
        }
        $this->title =$this->post->title;
        $this->body =$this->post->body;
        $this->category =$this->post->category_id;
        $this->image =$this->post->image;
        $this->image_orignal =$this->post->image;
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.edit-post',[
            'categories'=>$categories,
            'post'      =>$this->post,
        ]);
    }
    public function update(): RedirectResponse
    {
        $this->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'body' => 'required',
            'image' => 'mimes:jpg,jpeg,gif,png|max:5000'
        ]);
        $post = Post::where('user_id',auth()->id())->find($this->post_id);
        if ($post){
            $data['title'] = $this->title;
            $data['body'] = $this->body;
            $data['category_id'] = $this->category;
            if (!empty($this->image)) {
                if (File::exists('assets/images/'.$this->image)){
                    unlink('assets/images/'.$this->image);
                }
                $image = $this->image;
                $fileName = Str::slug($this->title) . '.' . $image->getClientOriginalExtension();
                $path = public_path('/assets/images/' . $fileName);
                Image::make($image->getRealPath())->save($path, 100);
                $data['image'] = $fileName;
            }
            $post->update($data);
            $this->reset();
            session()->flash('message','Post created successfully');
            return redirect()->route('index.post');
        }
        session()->flash('message_error','You Can not update not yours');
        return redirect()->route('index.post');

    }
    public function return_to_posts(): RedirectResponse
    {
        return redirect()->route('index.post');
    }
}
