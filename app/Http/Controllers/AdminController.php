<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\AllCategory;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Products;

class AdminController extends Controller
{
    public function logout()
    {

        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    // public function index()
    // {
    //     $categories = Category::where('parent_id', '=', 0)->get();
    //     $allCategories = Category::pluck('title','id')->all();
    //     return view('admin.categoryTreeview',compact('categories','allCategories'));
    // }


    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //     		'title' => 'required',
    //     	]);
    //     $input = $request->all();
    //     $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        
    //     Category::create($input);
    //     return back()->with('success', 'New Category added successfully.');
    // }
    
    //==========================================category Controllers =============================
    public function category()
    {

        $category = AllCategory::all();
        return view('admin.category', compact('category'));
    }

 
    public function add_category(Request $request)
    {
        if ($request->file('img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('img')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
            'category_name' => 'required',
            'img' => 'required',
        ]);

        $category = new AllCategory();
        $category->category_name = $request->category_name;
        $category->img =  "images/" . $image_name;
        $category->save();
        return redirect(route('category', compact('category')))->with('success', 'Category Added successfully');
    }

    public function categories()
    {
        $categories = AllCategory::all();
        return view('admin.all_categories', compact('categories'));
    }

    public function edit_category($id)
    {

        $category = AllCategory::find($id);
        return response()->json([
            'status' => '200',
            'category' => $category,
        ]);
    }

    public function category_update(Request $request)
    {
  
        $request->validate([
            'category_name' => 'required',
        ]);

        $cat_id = $request->query_id;
        
        $category = AllCategory::findOrFail($cat_id);
 

        if ($request->file('img') == null) {

            $image_name = $category->img;
          

        } else {

            $path_title = $request->file('img')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }

        $category->category_name = $request->category_name;
        $category->img =  $image_name;
        $category->save();
        return redirect()->back()->with('success', 'Category Updated successfully');
    }

    public function category_delete(Request $request)
    {

        $category_id = $request->delete_category_id;
        $product = Products::where('cat_id', $category_id);
        $product->delete();
        $subcat = SubCategory::where('cat_id', $category_id);
        $subcat->delete();
        $category = AllCategory::findOrFail($category_id);
        $category->delete();
        return redirect()->back()->with('error', 'Category Deleted successfully');
        
    }

    //=============================Sub Category Controller========================================
    public function subcategory($id)
    {
        $sub_categories = SubCategory::where('cat_id', $id)->get();
        $cat = AllCategory::findOrFail($id);
        return view('admin.sub_category', compact('sub_categories','cat'));
    }

    public function show_sub_category($id)
    {
        $sub_categories = SubCategory::where('cat_id', $id)->get();
        $cat = AllCategory::findOrFail($id);
        return view ('admin.managesubcat',compact('cat','sub_categories'));
    }

    public function add_sub_category(Request $request)
    {
        if ($request->file('img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('img')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
            'subcategory_name' => 'required',
            'img' => 'required',
        ]);

        $subcatgory = new SubCategory();
        $subcatgory->cat_id = $request->cat_id;
        $subcatgory->subcategory_name = $request->subcategory_name;
        $subcatgory->img =  "images/" . $image_name;
        $subcatgory->save();
        return redirect(route('showsubCategory',['id' => $request->cat_id ], compact('subcatgory')))->with('success', 'Sub-Category Added successfully');
    }

    public function edit_sub_category($id)
    {
        
        $subcategory = SubCategory::find($id);
        return response()->json([
            'status' => '200',
            'subcategory' => $subcategory,
        ]);
    }

    public function sub_category_update(Request $request)
    {
  
  
        $request->validate([
            'sub_category_name' => 'required',
        ]);

        $sub_cat_id = $request->query_id;
        
        $subcategory = SubCategory::find($sub_cat_id);
      

        if ($request->file('img') == null) {

            $image_name = $subcategory->img;
          

        } else {

            $path_title = $request->file('img')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }
        $subcategory->cat_id = $request->cat_id;
        $subcategory->subcategory_name = $request->sub_category_name;
        $subcategory->img =  $image_name;
        $subcategory->save();
        return redirect()->back()->with('success', 'SubCategory Updated successfully');
    }

    
    public function sub_category_delete(Request $request)
    {

        $sub_category_id = $request->delete_sub_category_id;
        $product = Products::where('subcat_id', $sub_category_id);
        $product->delete();
        $sub_category = SubCategory::findOrFail($sub_category_id);
        $sub_category->delete();
        return redirect()->back()->with('error', 'Sub-Category Deleted successfully');
        
    }

       //================================Products Controller========================================
       public function products($id)
       {
           $subcat = SubCategory::findOrFail($id);
           $products = Products::where('cat_id', $subcat->cat_id)->where('subcat_id', $subcat->id)->get();
           return view('admin.products', compact('products','subcat'));
       }

       public function show_products($id)
       {
        $subcat = SubCategory::findOrFail($id);
        $products = Products::where('cat_id', $subcat->cat_id)->where('subcat_id', $subcat->id)->get();
           return view ('admin.manage_products',compact('products','subcat'));
       }

       public function add_products(Request $request)
    {
        if ($request->file('img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('img')->store('public/images');

            $image_name = basename($path_title);
        }

        $request->validate([
            'product_name' => 'required',
            'img' => 'required',
            'desc' => 'required',
            'price' => 'required',
        ]);

        $products = new Products();
        $products->cat_id = $request->cat_id;
        $products->subcat_id = $request->subcat_id;
        $products->product_name = $request->product_name;
        $products->img =  "images/" . $image_name;
        $products->description = $request->desc;
        $products->price = $request->price;
        $products->save();
        return redirect(route('show_products',['id' => $request->subcat_id ], compact('products')))->with('success', 'Products Added successfully');
    }

    public function edit_products($id)
    {
        
        $product = Products::find($id);
        return response()->json([
            'status' => '200',
            'product' => $product,
        ]);
    }

    
    public function product_update(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'desc' => 'required',
            'price' => 'required',
        ]);

        $product_id = $request->query_id;
        
        $products = Products::find($product_id);
      

        if ($request->file('img') == null) {

            $image_name = $products->img;
          

        } else {

            $path_title = $request->file('img')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }
        $products->cat_id = $request->cat_id;
        $products->subcat_id = $request->subcat_id;
        $products->product_name = $request->product_name;
        $products->img =  $image_name;
        $products->description = $request->desc;
        $products->price = $request->price;
        $products->save();
        return redirect()->back()->with('success', 'Product Updated successfully');
    }

    public function product_delete(Request $request)
    {

        $product_id = $request->delete_product_id;
        $product_id = Products::findOrFail($product_id);
        $product_id->delete();
        return redirect()->back()->with('error', 'Product Deleted successfully');
        
    }

}
