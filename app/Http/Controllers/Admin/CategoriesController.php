<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Session\Session;


class CategoriesController extends Controller
{
    //function index
    public function index(Request $request)
    {
        $categories = Category::when($request->name, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")
                    ->orWhere('description', 'LIKE', "%{$value}%");
            });
        })
            ->when($request->parent_id, function ($query, $value) {
                $query->where('parent_id', '=', $value);
            })
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])->get();





        // طريقة اخرى
        /*
        $query = Category::query();
        if($request->name){
            $query->where(function($query) use($request){
               $query->where('name', 'LIKE', "%{$request->name}%")
                ->orWhere('description', 'LIKE', "%{$request->name}%");
            });
        }
        if($request->parent_id){
            $query->where('parent_id', '=', $request->parent_id);
        }
        $categories = $query->get();
        */

        $parents = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);
    }


    // function create
    public function create()
    {
        // ارسال بيانات لصفحة العرض
        $parents = Category::orderBy('name', 'asc')->get(); // return collection of data from category class
        return View::make('admin.categories.create', [
            'parents' => $parents, // with(name , value) تمرير بيانات لشاشة العرض
            'title' => 'Add Category',
            'category' => new Category(),
        ]);
    }


    public function store(Request $request)
    {

        $category = new Category();
        $category->name = $request->name; // $request->get('name')
        $category->parent_id = $request->post('parent_id');
        $category->slug = Str::slug($request->name);
        $category->description = $request->input('description');
        $category->status = $request->post('status'); //بترجع الداتا من البوست فقط
        $category->save();

        return Redirect::route('admin.categories.create')
            ->with('success', 'Added Successfully'); // flash message
    }

    public function edit($id)
    {

        //$category = Category::where('id', '=', $id)->first();
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '<>', $id)->get();
        // orderBy('name', 'asc')->get();
        return view('admin.categories.edit', [
            'id' => $id,
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, $id)
    {

        $category = Category::find($id);
        $category->name = $request->name; // $request->get('name')
        $category->parent_id = $request->post('parent_id');
        $category->slug = Str::slug($request->name);
        $category->description = $request->input('description');
        $category->status = $request->post('status'); //بترجع الداتا من البوست فقط
        $category->save();


        // session()->flash('success', 'Updateddd successfully');

        return redirect(route('admin.categories.index'))->with('success', 'Category Updated'); // flash message
    }

    public function destroy($id)
    {
        //Method 1
        // $category = Category::find($id);
        // $category->delete();

        // //Method 2
        // Category::where('id', '=', $id)->delete();

        //Method 3
        Category::destroy($id);

        return redirect(route('admin.categories.index'))->with('success', 'Category Deleted');
    }

    public function show($id)
{
    return __METHOD__;
    return view('admin.categories.show', [
        'category' => Category::findOrFail($id)
    ]);
}}
