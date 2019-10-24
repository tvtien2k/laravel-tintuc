<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function getDanhSach()
    {
        $user = User::all();
        return view('admin.user.danhsach', ['user' => $user]);
    }

    public function getThem()
    {
        return view('admin.user.them');
    }

    public function postThem(Request $request)
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
                'repasword.same' => 'Mật khẩu không khớp'
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = $request->quyen;
        $user->save();
        return redirect('admin/user/them')->with('thongbao', 'Thêm người dùng thành công');
    }

    public function getSua($id)
    {
        $user = User::find($id);
        return view('admin.user.sua', ['user' => $user]);
    }

    public function postSua(Request $request, $id)
    {
        $user = User::find($id);
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
        $user->quyen = $request->quyen;
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
        return redirect('admin/user/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công');
    }

    public function getDangNhap()
    {
        return view('admin/login');
    }

    public function postDangNhap(Request $request)
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
            return redirect('admin/theloai/danhsach');
        } else {
            return redirect('admin/dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }
    }

    public function getDangXuat()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
