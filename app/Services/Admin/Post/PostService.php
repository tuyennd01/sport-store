<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use App\Services\Service;
use Illuminate\Support\Str;


class PostService extends Service
{
    public function listPost()
    {
        return Post::getAllPost();
    }

    public function storePost($request)
    {
        $data = $request->all();

        $slug = Str::slug($request->title);
        $count = Post::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        $tags = $request->input('tags');
        if ($tags) {
            $data['tags'] = implode(',', $tags);
        } else {
            $data['tags'] = '';
        }

        $status = Post::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi thêm bài viết');
        }
    }

    public function updatePost($request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->all();
        $tags = $request->input('tags');
        // return $tags;
        if ($tags) {
            $data['tags'] = implode(',', $tags);
        } else {
            $data['tags'] = '';
        }

        $status = $post->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật bài viết');
        }
    }

    public function destroyPost($id)
    {
        $post = Post::findOrFail($id);
        $status = $post->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa bài viết thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa bài viết');
        }
    }
}
