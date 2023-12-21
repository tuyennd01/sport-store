<?php

namespace App\Services\Admin\Product;

use App\Models\Product;
use App\Models\ProductReview;
use App\Notifications\StatusNotification;
use App\Services\Service;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class ReviewProductService extends Service
{
    public function listProductReivew()
    {
        return ProductReview::getAllReview();
    }

    public function storeProductReview($request)
    {
        $product_info = Product::getProductBySlug($request->slug);

        $data = $request->all();
        $data['product_id'] = $product_info->id;
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'active';

        $status = ProductReview::create($data);

        $user = User::where('role', 'admin')->get();
        $details = [
            'title' => 'Có một đánh giá sản phẩm mới',
            'actionURL' => route('product-detail', $product_info->slug),
            'fas' => 'fa-star'
        ];
        Notification::send($user, new StatusNotification($details));

        if ($status) {
            request()->session()->flash('success', 'Cảm ơn bạn đã đánh giá');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi đánh giá sản phẩm');
        }
    }

    public function updateProductReview($request, $id)
    {
        $review = ProductReview::find($id);
        if ($review) {
            $data = $request->all();
            $status = $review->fill($data)->update();

            if ($status) {
                request()->session()->flash('success', 'Đánh giá sản phẩm cập nhật thành công');
            } else {
                request()->session()->flash('error', 'Gặp lỗi khi cập nhật đánh giá sản phẩm');
            }
        } else {
            request()->session()->flash('error', 'Đánh giá không tìm thấy!!');
        }
    }

    public function destroyProduct ($id) {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Xóa sản phẩm thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa sản phẩm');
        }
    }
}
