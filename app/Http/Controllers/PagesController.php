<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Slide;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;
use App\User;

class PagesController extends Controller
{
    function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai', $theloai);
        view()->share('slide', $slide);
    }

    function trangchu()
    {
        return view('pages.trangchu');
    }

    function lienhe()
    {
        return view('pages.lienhe');
    }

    function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
        return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
    }

    function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc', ['tintuc' => $tintuc, 'tinnoibat' => $tinnoibat, 'tinlienquan' => $tinlienquan]);
    }

    function getDangNhap()
    {
        return view('pages.dangnhap');
    }

    function postDangNhap(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Bạn chưa nhập Email',
                'password.required' => 'Bạn chưa nhập mật khẩu'
            ]);
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            return redirect('trangchu');
        } else {
            return redirect('dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }
    }

    function getDangXuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }

    function gioithieu()
    {
        return view('pages.gioithieu');
    }

    function getCaiDat()
    {
        return view('pages.caidat');
    }

    public function postCaiDat(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->validate($request,
            [
                'name' => 'required|min:3'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.min' => 'Họ tên phải chứa ít nhất 3 kí tự'
            ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->changePass == "on") {
            $this->validate($request,
                [
                    'password' => 'required|min:3|max:32',
                    'repassword' => 'required|same:password'
                ],
                [
                    'password.required' => 'Bạn chưa nhập password',
                    'password.min' => 'Password có độ dài từ 3 đến 32 kí tự',
                    'password.max' => 'Password có độ dài từ 3 đến 32 kí tự',
                    'repassword.required' => 'Bạn chưa xác nhận password',
                    'repasword.same' => 'Mật khẩu không khớp'
                ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect('caidat')->with('thongbao', 'Sửa thành công');
    }

    function getDangKi()
    {
        return view('pages.dangki');
    }

    function postDangKi(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'repassword' => 'required|same:password'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên',
                'name.min' => 'Họ tên phải chứa ít nhất 3 kí tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Bạn chưa nhập đứng định dạng email',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Bạn chưa nhập password',
                'password.min' => 'Password có độ dài từ 3 đến 32 kí tự',
                'password.max' => 'Password có độ dài từ 3 đến 32 kí tự',
                'repassword.required' => 'Bạn chưa xác nhận password',
                'repassword.same' => 'Mật khẩu không khớp'
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();
        return redirect('dangki')->with('thongbao', 'Đăng kí thành công');
    }

    function timkiem(Request $request)
    {
        if (!isset($request)) {
            return redirect()->back();
        }
        $this->validate($request,
            [
                'tukhoa' => 'required'
            ],
            [
                'name.required' => 'Bạn chưa nhập từ khóa'
            ]);

        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe', 'like', "%$tukhoa%")->orWhere('TomTat', 'like', "%$tukhoa%")->orWhere('NoiDung', 'like', "%$tukhoa%")->take(100)->paginate(5);
        return view('pages.timkiem', ['tintuc' => $tintuc, 'tukhoa' => $tukhoa]);
    }

}
