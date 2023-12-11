<?php

namespace App\Services\Admin;

use App\Models\Banner;
use App\Services\Service;
use Illuminate\Support\Str;


class BannerService extends Service
{
    public function listBanner()
    {
        return Banner::orderBy('id', 'DESC')->paginate(10);
    }

    public function storeBanner($request)
    {
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;
        $status = Banner::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm banner thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm banner');
        }
    }

    public function updateBanner($request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $request->all();

        $status = $banner->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật banner thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật banner');
        }
    }

    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $status = $banner->delete();
        if ($status) {
            request()->session()->flash('success', 'Xóa banner thành công');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting banner');
        }
    }
}
