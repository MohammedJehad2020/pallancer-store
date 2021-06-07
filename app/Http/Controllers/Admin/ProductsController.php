<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->latest()->orderBy('name', 'ASC')->paginate();
        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => Category::all(),
            'tag' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::validateRules());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
            'store_id' => 1,
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->store('/images', 'public');
        }
        /*
        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $product = Product::create($data);
*/

        

        $product = Product::create($data);
        $product->tags()->attach($this->getTags($request));//استخدم الاتاش بدل الاسنك لانه المنتج جديد ولم يخزن له تاق مسبقا في قاعدة البيانات

        /*$product = new Product($request->all());
        $product->save();*/

        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) created!");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $tags = $product->tags()->pluck('name')->toArray();
        // dd($tags);
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'tags' => implode(',', $tags),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate(Product::validateRules());

        $data = $request->all();
        $previous = false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            //$file->getclientOriginalName()
            // $file->getClientOriginalExtension();
            // $file->getSize();
            // $file->getMimeType();
            $data['image'] = $file->storeAs('/images', $file->getclientOriginalName(), [
                'disk' => 'public'
            ]);
            $previous = $product->image;
        }

        $product->update($data); // save for update
        if ($previous) {
            Storage::disk('storage')->delete($previous);
        }
        // $product->fill($request->all())->save();   //طريقة اخرى لعمل ميثود التحديث

        $product->tags()->sync($this->getTags($request));//  بتعمل عملية الربط بين التاق والمنتجات و حذف اي تاق غير مرتبطين مع منتجات في الجدول الوسيط

        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        if ($product->image) {
            Storage::disk('storage')->delete($product->image);
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product ($product->name) deleted!");
    }

    protected function getTags(Request $request)
    {
        $tag_ids = [];
        $tags = $request->post('tags');
        $tags = json_decode($tags);// حول الجيسون الى اوبجكت داخل اري
        //DB::table('product_tag')->where('product_id', '=', $product->id)->delete();//حذف كل التاق المرتبطة بهذا المنتج
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $tag_name = $tag->value; // بترجع القيم التي تم ادخالها في حقل التاق
                $tag_Model = Tag::firstOrCreate([ // فحص القيم التي تم ادخالها مع القيم المخزنة في جدول التاق اذا مش موجودة يتم انشائها
                    'name' => $tag_name,
                ], [
                    'slug' => Str::slug($tag_name),
                ]);

                /* $tag_Model = Tag::where('name', $tag_name)->first();// فحص القيم التي تم ادخالها مع القيم المخزنة في جدول التاق
                if(!$tag_Model){
                    $tag_Model = Tag::create([
                        'name' => $tag_name,
                        'slug' => Str::slug($tag_name),
                    ]);
                }
                DB::table('product_tag')->insert([
                    'product_id' => $product->id,
                    'tag_id' => $tag_Model->id,
                ]);*/
                $tag_ids[] = $tag_Model->id;// رجع الايدي الخاص بكل تاق موجودة في الجدول و خزنه في اري
            }
        }
        return $tag_ids;
        // $product->tags()->sync($product_tag);
    }
}
