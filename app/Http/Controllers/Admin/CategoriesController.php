<?php

namespace App\Http\Controllers\Admin;

use App\Rules\CheckAge;
use App\Models\Category;
use App\Models\Register;
use App\Rules\WordsFillter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\Validated;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    // register function
    public function register(){

        return view('user.register');

    }

    
    public function infoStore(Request $request)
    {

        $this->validateInfoRegister($request);

        $register = new Register();
        $register->name = $request->name;
        // $register->slug = Str::slug($request->name);
        $register->email = $request->input('email');
        $register->password = $request->post('password'); 
        $register->gender = $request->gender;
        $register->birthday = $request->birthday;
        $register->phone = $request->phone;
        $register->save();

        return Redirect::route('register')
            ->with('success', 'Registered Successfully'); // flash message
    }


    //function index
    public function index(Request $request)
    {
        $categories = Category::when($request->name, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('categories.name', 'LIKE', "%{$value}%")
                    ->orWhere('categories.description', 'LIKE', "%{$value}%");
            });
        })
            ->when($request->parent_id, function ($query, $value) {
                $query->where('categories.parent_id', '=', $value);
            })/*
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])*/
            ->with('parent')
            ->get();
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
        return View::make('admin.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);
    }

    public function product()
    {
        return View::make('admin.categories.product');
    }

    public function dashboard()
    {
        return View::make('admin.categories.dashboard');
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

        $this->validateRequest($request);

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
        if ($category == null) {
            abort(404);
        }

        $this->validateRequest($request, $id);

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
    }

    protected function validateRequest(Request $request, $id = 0)
    {
        return $request->validate(
            [ // rules
            'name' => [
                'required',
                'alpha',
                'max:255',
                'min:3',
                //"unique:categories,name,$id",
                //(new Unique('categories', 'name'))->ignore($id),
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'description' => [
                'nullable',
                'min:5',
                /* function($attribut, $value, $fail){
                     if(stripos($value, 'laravl') !== false){
                         $fail('You an not use the word "laravl"!');
                     }
                }*/
                // new WordsFillter(['php', 'laravel']),
                'filter:laravel,php'
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'image',
                'max:1048576',
                'dimentions:min_width=200,min_height=200'
            ],
            'status' => 'required|in:active,inactive'
        ],
        [ /// error messages
           'name.required' => 'هذا الحقل مطلوب'
        ],
    );
    }

    protected function validateInfoRegister(Request $request){
        return $request->validate(
            [
                'name' => 'required|max:255|min:3',
                'email' =>'required|unique:register,email|email',
                'password' => [
                    'required',
                      'min:8',
                    ],
                'gender' => 'required|in:male,female',
                 'birthday' => [
                     'required',
                      new CheckAge(),
                    ],
                 'phone' => 'required|regix:/^(059|056)\-?([0-9]{7})$/',
                
            ],
            [
              'name.required' => 'هذا الحقل مطلوب',
              'email.required' => 'هذا الحقل مطلوب',
              'email.unique'=> 'الايميل غير صالح', 
            ],
        );
    }
}
