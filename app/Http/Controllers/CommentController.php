<?php

namespace App\Http\Controllers;

use App\TinTuc;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getXoa($id, $idTinTuc)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/tintuc/sua/' . $idTinTuc)->with('thongbaocomment', 'Bạn đã xóa comment thành công');
    }

    public function postThem($idTinTuc, Request $request)
    {
        $this->validate($request,
            [
                'NoiDung' => 'required',
            ],
            [
                'NoiDung.required' => 'Bạn chưa nhập nội dung',
            ]);

        $comment = new Comment();
        $comment->idUser = Auth::user()->id;
        $comment->idTinTuc = $idTinTuc;
        $comment->NoiDung = $request->NoiDung;
        $comment->save();
        $TenKhongDau = TinTuc::find($idTinTuc)->TenKhongDau;
        return redirect('tintuc/' . $idTinTuc . '/' . $TenKhongDau)->with('thongbao', 'Thêm thành công');
    }

    public function getXoaPublic($id, $idTinTuc)
    {
        $comment = Comment::find($id);
        $comment->delete();
        $TenKhongDau = TinTuc::find($idTinTuc)->TenKhongDau;
        return redirect('tintuc/' . $idTinTuc . '/' . $TenKhongDau)->with('thongbao', 'Bạn đã xóa comment thành công');
    }
}
