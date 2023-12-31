@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Thêm sản phẩm</h5>
        <div class="card-body">
            <form method="post" action="{{route('product.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}"
                           class="form-control">
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
                    <label for="productType">Loại Sản Phẩm</label>
                    <select name="type_product" id="productType" class="form-control">
                        <option value="default">Chọn loại sản phẩm</option>
                        <option value="clothing">Quần Áo</option>
                        <option value="shoes">Giày</option>
                        <option value="others">Dụng Cụ Khác</option>
                    </select>
                </div>

                <div id="additionalFields" style="display: none;">
                    <label id="select-size" for="sizeOptions">Chọn Size:</label><br>
                    <div id="sizeOptions"></div>

                    <div id="quantityInputs"></div>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Giá nhập vào(VND) <span
                            class="text-danger">*</span></label>
                    <input id="price" type="number" name="original_price" placeholder="Giá nhập vào"
                           value="{{old('price')}}" class="form-control">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Giá bán ra(VND) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Giá bán ra" value="{{old('price')}}"
                           class="form-control">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Giảm giá(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Nhập % khuyến mãi"
                           value="{{old('discount')}}" class="form-control">
                    @error('discount')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
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
                        <option value="">--Chọn tình trạng--</option>
                        <option value="default">Default</option>
                        <option value="new">New</option>
                        <option value="hot">Hot</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
                    <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Chọn
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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function () {
            $('#summary').summernote({
                placeholder: "Viết mô tả ngắn...",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function () {
            $('#description').summernote({
                placeholder: "Viết mô tả ...",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();

    </script>

    <script>
        $('#cat_id').change(function () {
            var cat_id = $(this).val();
            // alert(cat_id);
            if (cat_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function (response) {
                        if (typeof (response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            // alert(data);
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function (id, title) {
                                    html_option += "<option value='" + id + "'>" + title + "</option>"
                                });
                            } else {
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            } else {
            }
        })
    </script>
    <script>
        $(document).ready(function () {
            var savedQuantityValues = {};

            $("#productType").change(function () {
                var selectedProduct = $(this).val();
                $("#additionalFields").hide();

                if (selectedProduct === "clothing" || selectedProduct === "shoes") {
                    generateSizeOptions(selectedProduct);
                    $("#additionalFields").show();
                } else if (selectedProduct === "others") {
                    $("#additionalFields").show();
                    $("#sizeOptions").empty();
                    $("#select-size").hide();
                    $("#quantityInputs").html('<label for="quantityOther">Số Lượng:</label>' +
                        '<input type="number" name="stock_other_product" id="quantityOther" class="form-control">');
                } else {
                    // Reset fields if another option is selected
                    savedQuantityValues = {};
                    $("#sizeOptions").empty();
                    $("#quantityInputs").empty();
                }
            });

            // Use event delegation for dynamically generated checkboxes
            $(document).on('change', '#sizeOptions input[type="checkbox"]', function () {
                savedQuantityValues = saveQuantityInputs();
                generateQuantityInputs();
            });

            function generateSizeOptions(productType) {
                var sizes = [];
                var sizeOptionsContainer = $("#sizeOptions");
                sizeOptionsContainer.empty();

                if (productType === "clothing") {
                    sizes = ["XS", "S", "M", "L", "XL", "XXL", "XXXL"];
                } else if (productType === "shoes") {
                    sizes = ["36", "37", "38", "39", "40", "41", "42", "43"];
                }

                sizes.forEach(function (size) {
                    sizeOptionsContainer.append(
                        '<input type="checkbox" class="sizeCheckbox" id="size' + size + '"> ' + size
                    );
                });

                $("#quantityInputs").empty();
                restoreQuantityInputs(savedQuantityValues);
            }

            function generateQuantityInputs() {
                var container = $("#quantityInputs");
                container.empty();

                if ($("#productType").val() === "other") {
                    container.html('<label for="quantityOther">Số Lượng:</label>' +
                        '<input type="number" name="quantityOther" id="quantityOther" class="form-control">');
                } else {
                    $(".sizeCheckbox:checked").each(function () {
                        var size = $(this).attr("id").replace("size", "");
                        container.append(
                            '<label for="quantity' + size + '">Nhập số lượng cho size ' + size + ':</label>' +
                            '<input type="number" name="sizes[' + size + ']" id="quantity' + size + '" class="form-control" value="' + (savedQuantityValues[size] || 0) + '">' +
                            '<br>'
                        );
                    });
                }
            }

            function saveQuantityInputs() {
                var savedValues = {};
                $("#quantityInputs input[type='number']").each(function () {
                    var size = $(this).attr("id").replace("quantity", "");
                    savedValues[size] = $(this).val();
                });
                return savedValues;
            }

            function restoreQuantityInputs(savedValues) {
                $("#quantityInputs input[type='number']").each(function () {
                    var size = $(this).attr("id").replace("quantity", "");
                    $(this).val(savedValues[size] || 0);
                });
            }
        });

    </script>

@endpush
