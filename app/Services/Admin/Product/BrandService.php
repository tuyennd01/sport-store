<?php

namespace App\Services\Admin\Product;

use App\Models\Brand;
use App\Services\Service;
use Illuminate\Support\Str;


class BrandService extends Service
{
    public function listBrands()
    {
        return Brand::orderBy('id', 'DESC')->paginate();
    }

    public function createBrand()
    {
        return Brand::where('is_parent', 1)->orderBy('title', 'ASC')->get();
    }

    public function storeBrand($request)
    {
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Brand::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;

        $status = Brand::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm nhãn hàng thành công');
        } else {
            request()->session()->flash('error', 'Xảy ra lỗi khi thêm nhãn hàng');
        }
    }

    public function updateBrand($request, $id)
    {
        $brand = Brand::find($id);
        $data = $request->all();

        $status = $brand->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật nhãn hàng thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật nhãn hàng');
        }
    }

    public function destroyBrand($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $status = $brand->delete();
            if ($status) {
                request()->session()->flash('success', 'Xóa nhãn hàng thành công');
            } else {
                request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa nhãn hàng');
            }
            return redirect()->route('brand.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy nhãn hàng');
            return redirect()->back();
        }
    }
}
