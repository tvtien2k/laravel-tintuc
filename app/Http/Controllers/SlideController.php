<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends Controller
{
    public function getDanhSach()
    {
        $slide = Slide::all();
        return view('admin.slide.danhsach', ['slide' => $slide]);
    }

    public function getThem()
    {
        return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required',
                'NoiDung' => 'required',
                'link' => 'required'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
                'link.required' => 'Bạn chưa nhập link'
            ]);

        $slide = new Slide();
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->link = $request->link;

        if ($request->hasFile('Hinh')) {
            //Hàm kiểm tra dữ liệu
            $this->validate($request,
                [
                    //Kiểm tra đúng file đuôi .jpg,.jpeg,.png.gif
                    'Hinh' => 'mimes:jpg,jpeg,png,gif'
                ],
                [
                    //Tùy chỉnh hiển thị thông báo không thõa điều kiện
                    'Hinh.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif'
                ]
            );
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $Hinh = time() . "_" . $name;
            $file->move("upload/slide", $Hinh);
            $slide->Hinh = $Hinh;
        } else {
            return redirect('admin/slide/them')->with('thongbao', 'Bạn chưa chọn ảnh');
        }
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao', 'Thêm thành công');
    }

    public function getSua($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.sua', ['slide' => $slide]);
    }

    public function postSua(Request $request, $id)
    {
        $slide = Slide::find($id);
        $this->validate($request,
            [
                'Ten' => 'required',
                'NoiDung' => 'required',
                'link' => 'required'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
                'link.required' => 'Bạn chưa nhập link'
            ]);

        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->link = $request->link;

        if ($request->hasFile('Hinh')) {
            //Hàm kiểm tra dữ liệu
            $this->validate($request,
                [
                    //Kiểm tra đúng file đuôi .jpg,.jpeg,.png.gif
                    'Hinh' => 'mimes:jpg,jpeg,png,gif'
                ],
                [
                    //Tùy chỉnh hiển thị thông báo không thõa điều kiện
                    'Hinh.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif'
                ]
            );
            $file = $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $Hinh = time() . "_" . $name;
            $file->move("upload/slide", $Hinh);
            unlink("upload/slide/" . $slide->Hinh);
            $slide->Hinh = $Hinh;
        }
        $slide->save();
        return redirect('admin/slide/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        unlink("upload/slide/" . $slide->Hinh);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao', 'Bạn đã xóa thành công');
    }
}
