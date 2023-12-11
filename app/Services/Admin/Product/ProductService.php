<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use App\Services\Service;
use Illuminate\Support\Str;


class ProductService extends Service
{
    public function listProduct()
    {
        return Product::getAllProduct();
    }

    public function storeProduct($request)
    {
        $data = $request->all();
        dd($data);
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();

        if ($count > 0) {
            request()->session()->flash('error', 'Sản phẩm đã tồn tại');

            return;
        }

        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');

        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }

        $status = Product::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm sản phẩm');
        }
    }

    public function updateProduct($request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');

        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }

        $status = $product->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật sản phẩm');
        }
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa sản phẩm');
        }
    }
}
