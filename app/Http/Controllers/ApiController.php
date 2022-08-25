<?php

namespace App\Http\Controllers;

use App\Models\AllCategory;
use App\Models\BannerImg;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Products;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //=============================== User Login Api==========================
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
            'device_token' => 'required'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                $token  = User::find($user->id);
                $token->device_token = $request->device_token;
                $token->save();

                $res['status'] = true;
                $res['message'] = "Password Matched! You have Login successfully!";
                $res['data'] = User::find($user->id);
                return response()->json($res);
            } else {

                $res['status'] = false;
                $res['message'] = "Password mismatch";
                return response()->json($res);
            }
        } else {

            $res['status'] = false;
            $res['message'] = "User does not exist";
            return response()->json($res);
        }
    }

    //=========================== Add Users Api ======================================
    public function add_users(Request $request)
    {
        if ($request->file('profile_img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('profile_img')->store('public/images');

            $image_name = basename($path_title);
        }

        $rules = [
            'profile_img' => 'required',
            'name' => 'required | min:5',
            'username' => 'required',
            'dob' => 'required ',
            'address' => 'required',
            'phone' => 'required ',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

        ];

        $validator = FacadesValidator::make($request->all(), $rules);
        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }
        $request['password'] = Hash::make($request['password']);
        // $request['remember_token'] = Str::random(10);
        //$users = User::create($request->all());
        $users = new User();
        $users->name = $request->name;
        $users->profile_img = "images/" . $image_name;
        $users->username = $request->username;
        $users->dob = $request->dob;
        $users->address = $request->address;
        $users->phone = $request->phone;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->device_token = "";
        $users->save();

        if (is_null($users)) {

            $res['status'] = false;
            $res['message'] = "User Can't Insert Sucessfully";
            return response()->json($res);
        } else {

            $userss = User::where('email', $request->email)->first();
            $res['status'] = true;
            $res['message'] = "User Insert Sucessfully";
            $res['data'] = $userss;
            return response()->json($res);
        }
        return response()->json($users);
    }

    //================== Edit Users Api ====================================
    public function edit_user(Request $request)
    {

        $finduser = User::find($request->user_id);

        if ($request->file('profile_img') == null) {

            $image_name = $finduser->profile_img;
        } else {

            $path_title = $request->file('profile_img')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }

        if (is_null($finduser)) {

            $res['status'] = false;
            $res['message'] = "User not found";
            return response()->json($res);
        }

        $rules = [
            'name' => 'required | min:5',
            'username' => 'required',
            'dob' => 'required ',
            'address' => 'required',
            'phone' => 'required ',
            'email' => 'required|email',

        ];

        $validator = FacadesValidator::make($request->all(), $rules);
        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }
        $request['password'] = Hash::make($request['password']);
        // $request['remember_token'] = Str::random(10);
        //$users = User::create($request->all());
        $users = User::find($request->user_id);
        $users->profile_img = $image_name;
        $users->name = $request->name;
        $users->username = $request->username;
        $users->dob = $request->dob;
        $users->address = $request->address;
        $users->phone = $request->phone;
        $users->email = $request->email;
        $users->save();

        if (is_null($users)) {

            $res['status'] = false;
            $res['message'] = "User Can't Updated Sucessfully";
            return response()->json($res);
        } else {

            $userss = User::where('email', $request->email)->first();
            $res['status'] = true;
            $res['message'] = "User Updated Sucessfully";
            $res['data'] = $userss;
            return response()->json($res);
        }
        return response()->json($users);
    }

    //=================================category Api =============================================
    public function category()
    {

        $category = AllCategory::all();

        if (count($category) == 0) {

            $res['status'] = false;
            $res['message'] = "Category Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Category List";
            $res['data'] = $category;
            return response()->json($res);
        }
    }

    //=================================Subcategory Api =============================================
    public function Subcategory(Request $request)
    {

        $subcategory = SubCategory::where('cat_id', $request->cat_id)->get();

        if (count($subcategory) == 0) {

            $res['status'] = false;
            $res['message'] = "Subcategory Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Subcategory List";
            $res['data'] = $subcategory;
            return response()->json($res);
        }
    }

    //=================================products Api =============================================
    public function products(Request $request)
    {

        $products = Products::where('cat_id', $request->cat_id)->where('subcat_id', $request->subcat_id)->get();
        $data = [];
        if (count($products) == 0) {


            $res['status'] = false;
            $res['message'] = "products Not Found!";
            return response()->json($res, 404);
        } else {

            foreach ($products as $prud) {
                $img = ProductDetail::where('product_id', $prud->id)->get();
                $prud->Product_images = $img;
                array_push($data, $prud);
            }

            $res['status'] = true;
            $res['message'] = "products List";
            $res['data'] = $data;
            return response()->json($res);
        }
    }

    //===============================Add order_list against user Routes================================
    public function add_order_list(Request $request)
    {
        $result = json_decode($request->getContent(), true);


        $finduser = User::find($result['user_id']);

        if (is_null($finduser)) {

            $res['status'] = false;
            $res['message'] = "User not found";
            return response()->json($res);
        }

        $order_list = $result['order_list'];

        if (count($order_list) == 0) {

            $res['status'] = false;
            $res['message'] = "Products not Found";
            return response()->json($res);
        }

        $request->validate([
            'user_id' => 'required',
            'order_desc' => 'required',
            'total_items' => 'required',
            'total_price_order' => 'required',
        ]);

        $order = new Order();
        $order->user_id = $result['user_id'];
        $order->order_desc = $result['order_desc'];
        $order->total_items = $result['total_items'];
        $order->total_price = $result['total_price_order'];
        $order->save();
        foreach ($order_list as $list) {

            $order_details = new OrderDetail();
            $order_details->order_id = $order->id;
            $order_details->product_id = $list['product_id'];
            $order_details->total_products = $list['total_products'];
            $order_details->total_price = $list['total_price_products'];
            $order_details->save();
        }

        $this->sendNotification($order->user_id, 'Order Notification', 'Your Order Status is Pending Please wait!!');

        $res['status'] = true;
        $res['message'] = "Order Add Successfully!!";
        return response()->json($res);
    }

    //=================================order_list againt user Api =============================================
    public function order_list(Request $request)
    {


        $order = Order::where('user_id', $request->user_id)->get();
        $data = [];

        if (count($order) == 0) {

            $res['status'] = false;
            $res['message'] = "order_list Not Found!";
            return $res;
        } else {



            // dd($query);
            $order = Order::where('user_id', $request->user_id)->get();
            foreach ($order as $que) {
                // dd($que);
                $query = Order::where('orders.id', $que->id)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->join('product_details', 'order_details.product_id', '=', 'product_details.product_id')
                    ->select('product_details.product_img', 'orders.id')->first();

                $que->Order_Image = $query->product_img;
                array_push($data, $que);
            }


            $res['status'] = true;
            $res['message'] = "order_list against user List";
            $res['data'] = $order;
            return $res;
        }
    }

    //=================================pending_list againt user Api =============================================
    public function pending_list(Request $request)
    {


        $order = Order::where('user_id', $request->user_id)->where('status', 0)->get();
        $data = [];
        if (count($order) == 0) {

            $res['status'] = false;
            $res['message'] = "pending_list Not Found!";
            return response()->json($res, 404);
        } else {

            foreach ($order as $que) {
                // dd($que);
                $query = Order::where('orders.id', $que->id)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->join('product_details', 'order_details.product_id', '=', 'product_details.product_id')
                    ->select('product_details.product_img', 'orders.id')->first();

                $que->Order_Image = $query->product_img;
                array_push($data, $que);
            }

            $res['status'] = true;
            $res['message'] = "pending_list against user List";
            $res['data'] = $order;
            return $res;
        }
    }

    //=================================Approved_list againt user Api =============================================
    public function approved_list(Request $request)
    {


        $order = Order::where('user_id', $request->user_id)->where('status', 1)->get();
        $data = [];
        if (count($order) == 0) {

            $res['status'] = false;
            $res['message'] = "approved_list Not Found!";
            return response()->json($res, 404);
        } else {

            foreach ($order as $que) {
                // dd($que);
                $query = Order::where('orders.id', $que->id)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->join('product_details', 'order_details.product_id', '=', 'product_details.product_id')
                    ->select('product_details.product_img', 'orders.id')->first();

                $que->Order_Image = $query->product_img;
                array_push($data, $que);
            }

            $res['status'] = true;
            $res['message'] = "approved_list against user List";
            $res['data'] = $order;
            return $res;
        }
    }

    //=================================reject_list againt user Api =============================================
    public function reject_list(Request $request)
    {

        $order = Order::where('user_id', $request->user_id)->where('status', 2)->get();
        $data = [];
        if (count($order) == 0) {

            $res['status'] = false;
            $res['message'] = "reject_list Not Found!";
            return response()->json($res, 404);
        } else {

            foreach ($order as $que) {
                // dd($que);
                $query = Order::where('orders.id', $que->id)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->join('product_details', 'order_details.product_id', '=', 'product_details.product_id')
                    ->select('product_details.product_img', 'orders.id')->first();

                $que->Order_Image = $query->product_img;
                array_push($data, $que);
            }

            $res['status'] = true;
            $res['message'] = "reject_list against user List";
            $res['data'] = $order;
            return $res;
        }
    }


    //=================================banner_imgs Api =============================================
    public function banner_img()
    {

        $img = BannerImg::all();

        if (count($img) == 0) {

            $res['status'] = false;
            $res['message'] = " Not Found!";
            return response()->json($res, 404);
        } else {

            $res['status'] = true;
            $res['message'] = "Banner Images";
            $res['data'] = $img;
            return response()->json($res);
        }
    }

    public function sendNotification($user_id, $title, $msg)
    {
        $user = User::find($user_id);
        $usertoken = $user->device_token;

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

        // dd($response);
    }
}
