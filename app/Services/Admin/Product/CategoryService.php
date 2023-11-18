<?php

namespace App\Services\Admin\Product;

use App\Models\Category;
use App\Services\Service;
use Illuminate\Support\Str;


class CategoryService extends Service
{
    public function listCategory()
    {
        return Category::getAllCategory();
    }

    public function createCategory()
    {
        return Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
    }

    public function storeCategory($request)
    {
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Category::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;
        $data['is_parent'] = $request->input('is_parent', 0);

        $status = Category::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm danh mục thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm danh mục');
        }
    }

    public function updateCategory($request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->all();
        $data['is_parent'] = $request->input('is_parent', 0);

        $status = $category->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật danh mục thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật danh mục');
        }
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        $status = $category->delete();

        if ($status) {
            if (count($child_cat_id) > 0) {
                Category::shiftChild($child_cat_id);
            }
            request()->session()->flash('success', 'Xóa danh mục thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa danh mục');
        }
    }

    public function getChildByParent($request)
    {
        $category = Category::findOrFail($request->id);
        $child_cat = Category::getChildByParentID($request->id);

        if (count($child_cat) <= 0) {
            return response()->json(['status' => false, 'msg' => '', 'data' => null]);
        } else {
            return response()->json(['status' => true, 'msg' => '', 'data' => $child_cat]);
        }
    }
}
