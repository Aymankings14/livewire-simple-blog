<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category','user'])->orderBy('id','desc')->paginate(5);
        return view('fronted.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('fronted.create' ,compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'title' => 'required|max:255',
            'category' => 'required',
            'body' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5000'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['title']= $request->title;
        $data['category_id']= $request->category;
        $data['body']= $request->body;
        $data['user_id']= auth()->id();
        if ($image = $request->image){
            $fileName = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path= public_path('/assets/images/'.$fileName);
            Image::make($image->getRealPath())->save($path,100);
            $data['image']= $fileName;
            Post::create($data);
            return $fileName;
            return redirect()->route('posts.index')->with([
                'message'       =>  'Post Created Successfully',
                'alert-type'    =>  'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post= Post::with(['user','category'])->find($id);
        if ($post){
            return view('fronted.show', compact('post'));
        }
        return redirect()->route('posts.index')->with([
            'message'       =>  'you don\'t have permission to continue to this page',
            'alert-type'    =>  'danger'
        ]);    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post= Post::find($id);
        if ($post){
            $categories = Category::all();
            return view('fronted.edit', compact('post','categories'));
        }
        return redirect()->route('posts.index')->with([
            'message'       =>  'you don\'t have permission to continue to this page',
            'alert-type'    =>  'danger'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator= Validator::make($request->all(),[
            'title' => 'required|max:255',
            'category' => 'required',
            'body' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,gif,png|max:5000'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post= Post::find($id);

       if ($post){
           $data['title']= $request->title;
           $data['category_id']= $request->category;
           $data['body']= $request->body;
           if ($image = $request->image){
               if (File::exists('assets/images/'.$post->image)){
                   unlink( 'assets/images/'.$post->image);
               }
               $fileName = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
               $path= public_path('/assets/images/'.$fileName);
               Image::make($image->getRealPath())->save($path,100);
               $data['image']= $fileName;

           }
           $post->update($data);
           return redirect()->route('posts.index')->with([
               'message'       =>  'Post Updated Successfully',
               'alert-type'    =>  'success'
           ]);
       }
        return redirect()->route('posts.index')->with([
            'message'       =>  'you don\'t have permission to continue to this page',
            'alert-type'    =>  'danger'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post->image != ''){
            if (File::exists('assets/images/'.$post->image)){
                unlink('assets/images/'.$post->image);
            }
        }
        $post->delete();
        return redirect()->route('posts.index')->with([
            'message'       =>  'Post Deleted Successfully',
            'alert-type'    =>  'success'
        ]);
    }
}
