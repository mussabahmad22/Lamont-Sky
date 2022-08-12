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
use App\Models\ProductDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\BannerImg;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function users()
    {
        $users =  User::where('remember_token', NULL)->get();
        return view('admin.users', compact('users'));
    } 

    public function delete_user(Request $request)
    {
        $user_id = $request->delete_user_id;

        $order_all = Order::where('user_id', $user_id)->get();
        foreach($order_all as $order){
            $order_details = OrderDetail::where('order_id', $order->id);
            $order_details->delete();
        }
        $order = Order::where('user_id', $user_id);
        $order->delete();

        $users = User::findOrFail($user_id);
        $users->delete();
        return redirect(route('users'))->with('error', 'User Deleted successfully');
    }

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
        $products_all = Products::where('cat_id', $category_id)->get();
        foreach($products_all as $prud){

            $product_details = ProductDetail::where('product_id', $prud->id);
            $product_details->delete();
        }
        
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
        return view('admin.sub_category', compact('sub_categories', 'cat'));
    }

    public function show_sub_category($id)
    {
        $sub_categories = SubCategory::where('cat_id', $id)->get();
        $cat = AllCategory::findOrFail($id);
        return view('admin.managesubcat', compact('cat', 'sub_categories'));
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
        return redirect(route('showsubCategory', ['id' => $request->cat_id], compact('subcatgory')))->with('success', 'Sub-Category Added successfully');
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
        return view('admin.products', compact('products', 'subcat'));
    }

    public function show_add_products($id)
    {

        $subcat = SubCategory::findOrFail($id);
        $products = Products::where('cat_id', $subcat->cat_id)->where('subcat_id', $subcat->id)->get();
        $url = url('add_products') . "/" . $id;
        $title = 'Add Product';
        $text = 'Save';
        return view('admin.add_products', compact('products', 'subcat', 'url', 'title', 'text'));
    }

    public function show_products($id)
    {
        $subcat = SubCategory::findOrFail($id);
        $products = Products::where('cat_id', $subcat->cat_id)->where('subcat_id', $subcat->id)->get();
        return view('admin.manage_products', compact('products', 'subcat'));
    }

    public function add_products(Request $request)
    {

        $request->validate([
            'product_name' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'photos' => 'required',
        ]);

        $products = new Products();
        $products->cat_id = $request->cat_id;
        $products->subcat_id = $request->subcat_id;
        $products->product_name = $request->product_name;
        $products->description = $request->desc;
        $products->price = $request->price;
        $products->save();

        if ($request->file('photos') == null) {

            $prud_imgs = "";
        } else {

            $files = $request->file('photos');

            foreach ($files as $file) {

                $path_title = $file->store('public/images');

                $prud_imgs = basename($path_title);

                $product_details = new ProductDetail();
                $product_details->product_id = $products->id;
                $product_details->product_img ="images/" .  $prud_imgs;
                $product_details->save();
            }
        }

        return redirect(route('show_products', ['id' => $request->subcat_id], compact('products')))->with('success', 'Products Added successfully');
    }

    public function edit_products($id)
    {
        $product = Products::find($id);

        $url = url('product_update') . "/" . $id;
        $title = 'Edit Product';
        $text = 'Update';
        return view('admin.add_products',  ['product' => $product, 'url' => $url, 'title' => $title, 'text' => $text]);
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
        $products->cat_id = $request->cat_id;
        $products->subcat_id = $request->subcat_id;
        $products->product_name = $request->product_name;
        $products->description = $request->desc;
        $products->price = $request->price;
        $products->save();

        if ($request->file('photos') == null) {

            $prud_imgs = "";
            
        } else {

            $delete_imgs_prodcucts = ProductDetail::where('product_id', $request->query_id);
            $delete_imgs_prodcucts->delete();
    
            $files = $request->file('photos');

            foreach ($files as $file) {

                $path_title = $file->store('public/images');

                $prud_imgs = basename($path_title);

                $product_details = new ProductDetail();
                $product_details->product_id = $products->id;
                $product_details->product_img ="images/" .  $prud_imgs;
                $product_details->save();
            }
        }

        return redirect(route('show_products', ['id' => $request->subcat_id],));
    }

    public function product_delete(Request $request)
    {

        $product_id = $request->delete_product_id;
        $delete_prodcucts = ProductDetail::where('product_id', $product_id);
        $delete_prodcucts->delete();
        $product_id = Products::findOrFail($product_id);
        $product_id->delete();
        return redirect()->back()->with('error', 'Product Deleted successfully');
    }

    //==========================order controller ======================================

    public function order()
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name')->get();
        return view('admin.order', compact('query'));
    }

    public function order_details($id)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('orders.*', 'users.name', 'users.email', 'order_details.total_products', 'order_details.total_price', 'products.product_name', 'products.price')->where('orders.id', $id)->get();

        $query2 = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name', 'users.username', 'users.dob', 'users.address', 'users.phone', 'users.email')->where('orders.id', $id)->first();

        return view('admin.order_details', compact('query', 'query2'));
    }

    //=================================Banner Image ===============================
    public function banner_img()
    {

        $banner_imgs = BannerImg::all();
        return view('admin.banner_img', compact('banner_imgs'));
    }

    //=================================Add Banner Image ===============================    
    public function add_banner_img(Request $request)
    {

        $request->validate([

            'file_title' => 'required',

        ]);

        if ($request->file('file_title') == null) {
 
            $image_name =  "";
        } else {

            $path_title = $request->file('file_title')->store('public/images');

            $image_name = basename($path_title);
        }

        $banner = new BannerImg();
        $banner->banner_img = "images/" .  $image_name;
        $banner->save();
        return redirect()->back()->with('success', 'Banner Image added successfully');
    }

    public function ban_img_del(Request $request)
    {

        $query_id = $request->delete_banner_id;
        $ratings = BannerImg::findOrFail($query_id);
        $ratings->delete();
        return redirect()->back()->with('error', 'Banner Image Deleted successfully');
    }

    //==================================change order status =========================
    public function status(Request $request){

        $result = Order::find($request->id);
        $result->status = $request->val;
        $result->save();

        if($result->status == 0){
            $this->sendNotification($result->user_id, 'Order Notification','Your Order Status is Pending Please wait!!');
        }else if($result->status == 1){
            $this->sendNotification($result->user_id, 'Order Notification','Your Order Status Approved by Admin');
        } else if($result->status == 2){
            $this->sendNotification($result->user_id, 'Order Notification','Your Order Status is Cancel by Admin');
        }

    }


    public function sendNotification($user_id, $title ,$msg)
    {
        $user=User::find($user_id);
        $usertoken =$user->device_token;
          
        $SERVER_API_KEY = 'AAAAYFSJZLE:APA91bGHYMuxCf3gDsK0q3vkxHea4P7T5Cn3-uSUcIREm7e2luOwheo8QlfF5jGV8oXVKD0XCEQ5UDxCkY2VXjU9sKCBnrI6eNYuWDy4kW6Vv3t3X6RU6IjJHS0l5fvhW0wRq4iTAtlP';
  
        $data = [
            "registration_ids" => [$usertoken],
            "data" => [
                "title" => $title,
                "body" => $msg,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }
}
