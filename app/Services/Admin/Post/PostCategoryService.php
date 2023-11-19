<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Services\Service;
use Illuminate\Support\Str;


class PostCategoryService extends Service
{
    public function listPostCategory()
    {
        return PostCategory::orderBy('id', 'DESC')->paginate(10);
    }

    public function storePostCategory($request)
    {
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = PostCategory::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $status = PostCategory::create($data);


        if ($status) {
            request()->session()->flash('success', 'Thêm danh mục bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm danh mục bài viết');
        }
    }

    public function updatePostCategory($request, $id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $data = $request->all();
        $status = $postCategory->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật danh mục bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật danh mục bài viết');
        }
    }

    public function destroyPostCategory($id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $status = $postCategory->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa danh mục bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa danh mục bài viết');
        }
    }
}
