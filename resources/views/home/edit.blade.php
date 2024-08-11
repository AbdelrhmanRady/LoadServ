@extends("layouts.app")
@section("title") Edit Product @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/AddProduct.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@php $count = 1 @endphp

<div class="AddListing">
    <form class="AddListing-form" method="POST" action="{{route('home.update',$product->productId)}}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <h1>Add Product</h1>
        <input name="productId" type="text" hidden value="{{$product->productId}}">
        <fieldset>
            <legend style="font-size: 250%; font-weight: bold;">Product info</legend>

            <label for="productName">Product Name:</label>
            <input value="{{$product->productName}}" type="text" id="productName" name="productName" required><br>

            <label for="">Choose Main Category</label>
            <select name="mainCategory" id="mainCategory">
                <option value="" disabled>Select a main category</option>
                @foreach ($categories as $category)
                <option value="{{ $category->categoryName }}" 
                    {{ $product->mainCategory == $category->categoryName ? 'selected' : '' }}>
                    {{ $category->categoryName }}
                </option>
                @endforeach
            </select>

            <div id="subcategory_div" style="display: none">
                <label for="subcategory">Choose Subcategory</label>
                <select name="subCategory" id="subCategory">
                    <option value="" disabled selected>Select a subcategory</option>
                </select>
            </div>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{$product->description}}</textarea><br>

            <label for="price">Price:</label>
            <input value="{{$product->price}}" type="number" id="price" name="price" step="0.01" required><br>

            <div class="form-check">
                <label class="form-check-label" style="display: inline-block" for="hasSizes">Has Sizes?:</label>
                <input class="form-check-input" value="1" type="checkbox" {{$product->hasSizes ? 'checked' : ''}} id="hasSizes" name="hasSizes">
            </div>
            <br/>

            <div id="sizes-section" style="display: {{$product->hasSizes ? 'block' : 'none'}};">
                <h3>Sizes</h3>
                <div class="form-check">
                    <label class="form-check-label" style="display: inline-block" for="samePriceForAllSizes">Same Price for All Sizes?:</label>
                    <input class="form-check-input" value="1" type="checkbox" {{$product->samePriceForAllSizes ? 'checked' : ''}} id="samePriceForAllSizes" name="samePriceForAllSizes">
                </div>
                <div id="sizes-container">
                    @foreach ($sizes as $size)
                        <div>
                            <label class="sizeLabels" style="display: inline-block; margin-bottom: 5px" for="size{{$count}}">Size {{$count}}:</label>
                            <button class="btn btn-danger" style="display: inline-block; margin-bottom: 5px" type="button" onclick="removeSizeField(this)">Remove</button>
                            <br/>
                            <input value="{{$size->size}}" type="text" id="size{{$count}}" name="sizes[{{$count-1}}][size]" required>
                            <div class="differentPrices" style="display: {{$product->samePriceForAllSizes ? 'none' : 'block'}};">
                                <label class="pricelabels" for="price{{$count}}">Price {{$count}}:</label>
                                <input class="sizeprices" value="{{$size->price}}" type="number" id="price{{$count}}" name="sizes[{{$count-1}}][price]" step="0.01" {{$product->samePriceForAllSizes ? '' : 'required'}}>
                            </div>
                        </div>
                        @php $count += 1 @endphp
                    @endforeach
                </div>

                <button class="btn btn-primary" type="button" onclick="addSizeField()">Add Size</button>
                <br/><br/><br/>
            </div>

            <label for="stock">Stock:</label>
            <input value="{{$product->stock}}" type="number" id="stock" name="stock" required><br>

            
            <label for="image">Upload Image:</label>
            <input  type="file" id="image" name="image" accept="image/*"><br>

        </fieldset>

        <button id="submitButton" type="submit">Edit Product</button>

    </form>
</div>

<script>
    var index = 2;
    function updateLabels(){
        var pricelabels = document.querySelectorAll('.pricelabels');
        var sizeLabels = document.querySelectorAll('.sizeLabels');
        
        pricelabels.forEach((label, index) => {
        label.innerHTML = 'Price ' + (index + 1) + ':';
        });

        sizeLabels.forEach((label, index) => {
        label.innerHTML = 'Size ' + (index + 1) + ':';
        });
    }

    function updateSubCategories(){
            const categories = @json($categories);
            const selectedCategory = $("#mainCategory").val();
            const mainCategory = categories.find(category => category.categoryName === selectedCategory);
            const subCategories = mainCategory ? mainCategory.subCategories : [];

            $('#subcategory_div').show();
            const $subCategory = $('#subCategory');
            $subCategory.empty();

            subCategories.forEach((element,index) => {
                $subCategory.append(`<option value="${element}">${element}</option>`);
                
            });
    }
    $(document).ready(function() {


        $('#hasSizes').change(function() {
            $('#sizes-section').toggle(this.checked);
        });

        $('#samePriceForAllSizes').change(function() {
        $('.differentPrices').toggle(!this.checked);
        $('.sizeprices').attr('required', !this.checked);
    });

        updateSubCategories()
        $('#mainCategory').change(function() {
            updateSubCategories()
        });
        });

    // Add new size field
    var container = $('#sizes-container');
    var index = container.children().length + 1;
    
    function addSizeField() {
        index = index + 1;
        var display = $('#samePriceForAllSizes').prop('checked') ? "none" : "block";
        var required = $('#samePriceForAllSizes').prop('checked') ? "" : "required";
        const div = `
        <div>
            <label class="sizeLabels" style="display: inline-block; margin-bottom: 5px" for="size${index}">Size ${index}:</label>
            <button class="btn btn-danger" style="display: inline-block; margin-bottom: 5px" type="button" onclick="removeSizeField(this)">Remove</button>
            <br/>
            <input type="text" id="size${index}" name="sizes[${index - 1}][size]" required>
            <div class="differentPrices" style="display: ${display}">
                <label class="pricelabels" for="price${index}">Price ${index}:</label>
                <input class="sizeprices" type="number" id="price${index}" name="sizes[${index - 1}][price]" step="0.01" ${required}>
            </div>
        </div>
    `;
        container.append(div);
        updateLabels()
    }

    // Remove size field
    function removeSizeField(button) {
        if($(button).parent().parent().children().length == 1) return
        $(button).parent().remove();
        updateLabels()
    }
</script>
@endsection
