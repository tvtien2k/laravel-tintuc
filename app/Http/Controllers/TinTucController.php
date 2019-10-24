<?php

namespace App\Http\Controllers;

use App\TinTuc;
use App\LoaiTin;
use App\TheLoai;
use App\Comment;
use Illuminate\Http\Request;

class TinTucController extends Controller
{
    public function getDanhSach()
    {
        $tintuc = TinTuc::orderBy('id', 'DESC')->get();
        return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.min' => 'Tiêu đề phải có ít nhất 3 kí tự',
                'TieuDe.unique' => 'Tiêu đề đã tồn tại',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
            ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->Ten);
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->SoLuotXem = 0;
        $tintuc->idLoaiTin = $request->LoaiTin;

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
            $file->move("upload/tintuc", $Hinh);
            $tintuc->Hinh = $Hinh;
        } else {
            return redirect('admin/tintuc/them')->with('thongbao', 'Bạn chưa chọn ảnh');
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao', 'Thêm thành công');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua', ['theloai' => $theloai, 'loaitin' => $loaitin, 'tintuc' => $tintuc]);
    }

    public function postSua(Request $request, $id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                'LoaiTin' => 'required',
                'TieuDe' => 'required|min:3',
                'TomTat' => 'required',
                'NoiDung' => 'required'
            ],
            [
                'LoaiTin.required' => 'Bạn chưa chọn loại tin',
                'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
                'TieuDe.min' => 'Tiêu đề phải có ít nhất 3 kí tự',
                'TomTat.required' => 'Bạn chưa nhập tóm tắt',
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
            ]);

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->Ten);
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->idLoaiTin = $request->LoaiTin;

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
            $file->move("upload/tintuc", $Hinh);
            unlink("upload/tintuc/" . $tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        $tintuc->save();
        return redirect('admin/tintuc/sua/' . $tintuc->id)->with('thongbao', 'Sửa thành công');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        unlink("upload/tintuc/" . $tintuc->Hinh);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Bạn đã xóa thành công');
    }
}
