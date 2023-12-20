<?php

namespace App\Services\Admin\Post;

use App\Models\Post;
use App\Models\PostComment;
use App\Notifications\StatusNotification;
use App\Services\Service;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class PostCommentService extends Service
{
    public function listPostComment()
    {
        return PostComment::getAllComments();
    }

    public function storePostComment($request)
    {
        $post_info = Post::getPostBySlug($request->slug);
        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $data['status'] = 'active';

        $status = PostComment::create($data);
        $user = User::where('role', 'admin')->get();
        $details = [
            'title' => "Có bình luận bài viết mới!",
            'actionURL' => route('blog.detail', $post_info->slug),
            'fas' => 'fas fa-comment'
        ];
        Notification::send($user, new StatusNotification($details));
        if ($status) {
            request()->session()->flash('success', 'Cảm ơn bạn đã bình luận');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi bình luận');
        }
    }

    public function updatePostComment($request, $id)
    {
        $comment = PostComment::find($id);
        if ($comment) {
            $data = $request->all();
            // return $data;
            $status = $comment->fill($data)->update();
            if ($status) {
                request()->session()->flash('success', 'Cập nhật bình luận thành công');
            } else {
                request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật bình luận');
            }
            return redirect()->route('comment.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy bình luận');
            return redirect()->back();
        }
    }

    public function destroyPostComment($id)
    {
        $comment = PostComment::find($id);
        if ($comment) {
            $status = $comment->delete();
            if ($status) {
                request()->session()->flash('success', 'Xóa bình luận thành công');
            } else {
                request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa bình luận');
            }
            return back();
        } else {
            request()->session()->flash('error', 'Không tìm thấy bình luận');
            return redirect()->back();
        }
    }
}
