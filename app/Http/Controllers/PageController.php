<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\ProductType;
use App\Slide;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class PageController extends Controller
{
    //
    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = DB::table('products')->where('new', '=', 1)->paginate(4);
        $sanpham_khuyenmai = DB::table('products')
            ->where('promotion_price', '!=', 0)->paginate(8);
        return view('page.trangchu',
            compact('slide', 'new_product', 'sanpham_khuyenmai'));
    }

    public function getLoaiSp($type)
    {
        $sp_theoloai = DB::table('products')->where('id_type', '=', $type)
            ->get();
        $sp_khac = DB::table('products')->where('id_type', '!=', $type)
            ->paginate(3);
        $loai = ProductType::all();
        $loai_sanpham = DB::table('type_products')->where('id', '=', $type)
            ->first();
        return view('page.loai_sanpham',
            compact('sp_theoloai', 'sp_khac', 'loai', 'loai_sanpham'));
    }

    public function getChitiet(Request $request)
    {
        $sanpham = Product::where('id', $request->id)->first();
        $sanpham_tuongtu = Product::where('id_type', $sanpham->id_type)
            ->paginate(6);
        return view('page.chitiet_sanpham',
            compact('sanpham', 'sanpham_tuongtu'));
    }

    public function getLienHe()
    {
        return view('page.lienhe');
    }

    public function getGioiThieu()
    {
        return view('page.gioithieu');
    }

    public function getLogin()
    {
        return view('page.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:20',
            ],
            [
                'email.required' => 'Vui lòng nhập lại email',
                'email.email' => "Không đúng định dạng email",
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự',
                'password.max' => 'Mật khẩu Không quá 30 kí tự'
            ]);
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password
        );
        if (Auth::attempt($credentials)) {
            return redirect()->back()->with([
                'flag' => 'success',
                'messege' => 'đăng nhập thành công'
            ]);
        } else {
            return redirect()->back()->with([
                'flag' => 'danger',
                'messege' => 'đăng nhập không thành công'
            ]);

        }
    }

    public function getRegister()
    {
        return view('page.register');
    }

    public function postSignin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:20',
                'fullname' => 'required',
                're_password' => 'required|same:password'
            ],
            [
                'email.required' => 'Vui lòng nhập lại email',
                'email.email' => "Không đúng định dạng email",
                'email.unique' => 'Email đã có người dùng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                're_password.same' => 'Mật khẩu không giống nhau',
                'password.min' => 'Mật khẩu ít nhất 6 kí tự'
            ]);
        $user = new User();
        $user->full_name = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()
            ->with('Thanhcong', 'Đã tạo tài khoản thành công');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $request)
    {
        $product = Product::where('name', 'like', '%' . $request->key . '%')
            ->orWhere('unit_price', $request->key)
            ->get();
        return view('page.search',compact('product'));
    }

//    public function getAddToCart(Request $request ,$id){
//        $product = Product::find($id);
//        $oldCart = Session('cart')?Session::get('cart'):null;
//        $cart = new Cart($oldCart);
//        $cart->add($product,$id);
//        $request->session()->put('cart',$cart);
//        return redirect()->back();
//    }
}
