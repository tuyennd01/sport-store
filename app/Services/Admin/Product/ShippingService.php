<?php

namespace App\Services\Admin\Product;

use App\Models\Shipping;
use App\Services\Service;
use Illuminate\Support\Str;


class ShippingService extends Service
{
    public function listShipping()
    {
        return Shipping::orderBy('id', 'DESC')->paginate(10);
    }

    public function storeShipping($request)
    {
        $data = $request->all();
        $status = Shipping::create($data);

        if ($status) {
            request()->session()->flash('success', 'Thêm đơn vị giao hàng thành công');
        } else {
            request()->session()->flash('error', 'Xảy ra lỗi khi thêm đơn vị giao hàng');
        }
    }

    public function updateShipping($request, $id)
    {
        $shipping = Shipping::find($id);
        $data = $request->all();

        $status = $shipping->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Cập nhật đơn vị giao hàng thành công');
        } else {
            request()->session()->flash('error', 'Đã xảy ra lỗi khi cập nhật đơn vị giao hàng');
        }
    }

    public function destroyShipping($id)
    {
        $shipping = Shipping::find($id);
        if ($shipping) {
            $status = $shipping->delete();
            if ($status) {
                request()->session()->flash('success', 'Xóa đơn vị giao hàng thành công');
            } else {
                request()->session()->flash('error', 'Đã xảy ra lỗi khi xóa đơn vị giao hàng');
            }
            return redirect()->route('shipping.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy đơn vị giao hàng');
            return redirect()->back();
        }
    }
}
