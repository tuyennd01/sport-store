<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use App\Models\PostTag;
use App\Notifications\StatusNotification;
use App\Services\Service;
use App\User;
use Illuminate\Support\Str;


class PostTagService extends Service
{
    public function listPostTag()
    {
        return PostTag::orderBy('id', 'DESC')->paginate(10);
    }

    public function storePostTag($request)
    {
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = PostTag::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;
        $status = PostTag::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm tag bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm tag bài viết');
        }
    }

    public function updatePostTag($request, $id)
    {
        $postTag = PostTag::findOrFail($id);

        $data = $request->all();
        $status = $postTag->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật tag bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật tag bài viết');
        }
    }

    public function destroyPostTag($id)
    {
        $postTag = PostTag::findOrFail($id);

        $status = $postTag->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa tag bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa tag bài viết');
        }
    }
}
