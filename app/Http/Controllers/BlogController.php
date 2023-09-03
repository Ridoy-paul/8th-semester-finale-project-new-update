<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Image;
Use File;
use Alert;

class BlogController extends Controller
{
    
    public function index(){
        return view('admin.blog.create');
    }
    
    public function store(Request $request){
    
        $blog = new Blog;
        $blog->title=$request->title;
        //$blog->is_active=$request->is_active;
        $blog->description=$request->description;

        if ($request->image){
             $image = $request->file('image');
             $img = time() . '.' . $image->getClientOriginalExtension();
             $location = public_path('images/blog/'. $img);
             Image::make($image)->save($location);
             $blog->image = $img;
         }
        Alert::toast('New Blog added.', 'success');
        $blog->save();
        
        return redirect()->route('blog.list');
    }

    public function list(){
        $blogs=Blog::OrderBy('id', 'DESC')->get();
        return view('admin.blog.index',compact('blogs'));
    }

    public function edit($id){
        $blog = Blog::find($id);
        return view('admin.blog.edit',compact('blog'));
    }

    public function update(Request $request, $id){
        $blog = Blog::find($id);
        if(!is_null($blog)) {
            $blog->title = $request->title;
            $blog->description = $request->description;
    
            if ($request->image){

                if (File::exists('images/blog/'.$blog->image)){
                    File::delete('images/blog/'.$blog->image);
                }

                 $image = $request->file('image');
                 $img = time(). '.' . $image->getClientOriginalExtension();
                 $location = public_path('images/blog/'. $img);
                 Image::make($image)->save($location);
                 $blog->image = $img;
             }
             $blog->save();

             Alert::toast('Blog updated.', 'success');
             return redirect()->route('blog.list');
        }
        else {
            Alert::toast('No Blog Found.', 'error');
            return redirect()->back();
        }
        
         
    }

       public function destroy($id)
     {
      $testimonial = Blog::find($id);
         if (!is_null($testimonial)) {
             if (File::exists('images/testimonial/'.$testimonial->image)){
                 File::delete('images/testimonial/'.$testimonial->image);
             }
             $testimonial->delete();
             Alert::toast('testimonial has been deleted !', 'success');
            return redirect()->route('blog.list');
         }
         else {
             session()->flash('error','Something went wrong !');
            return redirect()->route('blog.list');
         }
     }


}
