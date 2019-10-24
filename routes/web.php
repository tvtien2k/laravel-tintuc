<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Trang admin

Route::get('/admin/dangnhap', 'UserController@getDangNhap');
Route::post('/admin/dangnhap', 'UserController@postDangNhap');
Route::get('/admin/dangxuat', 'UserController@getDangXuat');

Route::prefix('admin')->middleware('AdminLogin')->group(function () {
    Route::prefix('theloai')->group(function () {
        Route::get('/danhsach', 'TheLoaiController@getDanhSach');

        Route::get('/them', 'TheLoaiController@getThem');
        Route::post('/them', 'TheLoaiController@postThem');

        Route::get('/sua/{id}', 'TheLoaiController@getSua');
        Route::post('/sua/{id}', 'TheLoaiController@postSua');

        Route::get('/xoa/{id}', 'TheLoaiController@getXoa');
    });

    Route::prefix('loaitin')->group(function () {
        Route::get('/danhsach', 'LoaiTinController@getDanhSach');

        Route::get('/them', 'LoaiTinController@getThem');
        Route::post('/them', 'LoaiTinController@postThem');

        Route::get('/sua/{id}', 'LoaiTinController@getSua');
        Route::post('/sua/{id}', 'LoaiTinController@postSua');

        Route::get('/xoa/{id}', 'LoaiTinController@getXoa');
    });

    Route::prefix('tintuc')->group(function () {
        Route::get('/danhsach', 'TinTucController@getDanhSach');

        Route::get('/them', 'TinTucController@getThem');
        Route::post('/them', 'TinTucController@postThem');

        Route::get('/sua/{id}', 'TinTucController@getSua');
        Route::post('/sua/{id}', 'TinTucController@postSua');

        Route::get('/xoa/{id}', 'TinTucController@getXoa');
    });

    Route::prefix('ajax')->group(function () {
        Route::get('/loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
    });

    Route::prefix('comment')->group(function () {
        Route::get('/xoa/{id}/{idTinTuc}', 'CommentController@getXoa');
    });

    Route::prefix('slide')->group(function () {
        Route::get('/danhsach', 'SlideController@getDanhSach');

        Route::get('/them', 'SlideController@getThem');
        Route::post('/them', 'SlideController@postThem');

        Route::get('/sua/{id}', 'SlideController@getSua');
        Route::post('/sua/{id}', 'SlideController@postSua');

        Route::get('/xoa/{id}', 'SlideController@getXoa');
    });

    Route::prefix('user')->group(function () {
        Route::get('/danhsach', 'UserController@getDanhSach');

        Route::get('/them', 'UserController@getThem');
        Route::post('/them', 'UserController@postThem');

        Route::get('/sua/{id}', 'UserController@getSua');
        Route::post('/sua/{id}', 'UserController@postSua');

        Route::get('/xoa/{id}', 'UserController@getXoa');
    });
});

// Trang public

Route::get('/trangchu', 'PagesController@trangchu');
Route::get('/lienhe', 'PagesController@lienhe');
Route::get('/gioithieu', 'PagesController@gioithieu');

Route::get('/loaitin/{id}/{TenKhongDau}', 'PagesController@loaitin');

Route::get('/tintuc/{id}/{TieuDeKhongDau}', 'PagesController@tintuc');
Route::get('/tintuc/{id}', 'PagesController@tintuc');

Route::get('/dangnhap', 'PagesController@getDangNhap');
Route::post('/dangnhap', 'PagesController@postDangNhap');
Route::get('/dangxuat', 'PagesController@getDangXuat');

Route::get('/caidat', 'PagesController@getCaiDat');
Route::post('/caidat', 'PagesController@postCaiDat');

Route::get('/dangki', 'PagesController@getDangKi');
Route::post('/dangki', 'PagesController@postDangKi');

Route::post('/comment/them/{idTinTuc}', 'CommentController@postThem');
Route::get('/comment/xoa/{id}/{idTinTuc}', 'CommentController@getXoaPublic');

Route::get('/timkiem', 'PagesController@timkiem');


