@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Thêm Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Mô tả</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="is_featured">Nổi bật</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
        </div>
              {{-- {{$categories}} --}}

        <div class="form-group">
          <label for="cat_id">Danh mục <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Chọn danh mục sản phẩm--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Sub Danh mục</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Chọn danh mục sản phẩm phụ--</option>
              {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Giá(VND) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price"  value="{{old('price')}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Giảm giá(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"  value="{{old('discount')}}" class="form-control">
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
          <div class="form-group">
              <label for="productType">Loại Sản Phẩm</label>
              <select id="productType" class="form-control">
                  <option value="clothing">Quần Áo</option>
                  <option value="shoes">Giày</option>
                  <option value="others">Dụng Cụ Khác</option>
              </select>
          </div>

          <div class="form-group" id="sizeAndQuantity">
              <label for="size">Kích cỡ</label>
              <select name="size[]" id="size" class="form-control selectpicker" multiple data-live-search="true">
                  <!-- Options will be dynamically added based on the selected product type -->
                  <option value="">--Chọn kích cỡ--</option>
              </select>

              <div id="quantityInput" style="display: none;">
                  <label for="quantity">Số Lượng</label>
                  <div id="sizeQuantities"></div>
              </div>
          </div>

        <div class="form-group">
          <label for="brand_id">Nhãn hàng</label>
          {{-- {{$brands}} --}}

          <select name="brand_id" class="form-control">
              <option value="">--Chọn nhãn hàng--</option>
             @foreach($brands as $brand)
              <option value="{{$brand->id}}">{{$brand->title}}</option>
             @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="condition">Tình trạng</label>
          <select name="condition" class="form-control">
              <option value="">--Select Condition--</option>
              <option value="default">Default</option>
              <option value="new">New</option>
              <option value="hot">Hot</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Số lượng <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="{{old('stock')}}" class="form-control">
          @error('stock')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Đặt lại</button>
           <button class="btn btn-success" type="submit">Xác nhận</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
<script>
    $(document).ready(function() {
        // Sự kiện khi loại sản phẩm thay đổi
        $("#productType").change(function() {
            var selectedType = $(this).val();
            var sizeOptions = $("#size")[0];
            console.log(sizeOptions)
            var quantityInput = $("#quantityInput");
            var sizeQuantities = $("#sizeQuantities");

            // Xóa tất cả các option hiện tại và ô nhập số lượng
            sizeOptions.find("option").remove();
            sizeQuantities.empty();

            // Tùy thuộc vào loại sản phẩm, thêm các option phù hợp
            if (selectedType === "clothing") {
                addSizeOption("XS");
                addSizeOption("S");
                addSizeOption("M");
                addSizeOption("L");
                addSizeOption("XL");
                addSizeOption("XXL");
                addSizeOption("3XL");
            } else if (selectedType === "shoes") {
                for (var i = 36; i <= 43; i++) {
                    addSizeOption(i.toString());
                }
            }

            // Hiển thị ô nhập số lượng nếu có size được chọn
            if (sizeOptions.val()) {
                quantityInput.show();
            } else {
                quantityInput.hide();
            }

            // Cập nhật selectpicker
            sizeOptions.selectpicker('refresh');
        });

        // Sự kiện khi size được chọn thay đổi
        $("#size").change(function() {
            // Hiển thị hoặc ẩn ô nhập số lượng tùy thuộc vào việc có size được chọn hay không
            if ($(this).val()) {
                $("#quantityInput").show();
            } else {
                $("#quantityInput").hide();
            }

            // Hiển thị ô nhập số lượng cho từng size được chọn
            updateSizeQuantities();
        });

        // Hàm thêm option cho size và số lượng
        function addSizeOption(size) {
            sizeOptions.append('<option value="' + size + '">' + size + '</option>');
            sizeQuantities.append(
                '<div class="size-quantity">' +
                '<label for="quantity-' + size + '">Số Lượng (' + size + ')</label>' +
                '<input type="text" name="quantity-' + size + '" id="quantity-' + size + '" class="form-control">' +
                '</div>'
            );
        }

        // Hàm cập nhật hiển thị số lượng dựa trên size được chọn
        function updateSizeQuantities() {
            $(".size-quantity").hide();  // Ẩn tất cả các ô nhập số lượng

            // Hiển thị ô nhập số lượng cho từng size được chọn
            $.each($("#size").val(), function(index, size) {
                $("#quantity-" + size).parent().show();
            });
        }
    });
</script>
@endpush
