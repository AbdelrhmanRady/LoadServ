@extends("layouts.app")
@section("title") Add Product @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/AddProduct.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div class="AddListing">
        
        <form class="AddListing-form" method="POST" action="{{route("home.store")}}" enctype="multipart/form-data">
            @csrf
            <h1>Add Product</h1>

            
            <fieldset>
            
            <legend style="font-size: 250%; font-weight: bold;"> Product info</legend>

            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required><br>
            <label for="">Choose Main Category</label>
            <select required name="mainCategory" id ="mainCategory">
                <option value="" disabled selected>Select a main category</option>
                @foreach ($categories as $category)
                <option value="{{$category->categoryName}}"> {{$category->categoryName}} </option>
                @endforeach
            </select>
            <div id="subcategory_div" style="display: none">
                <label for="subcategory">Choose Subcategory</label>
                <select required name="subCategory" id="subCategory">
                    <option value="" disabled selected>Select a subcategory</option>

                </select>
            </div>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required><br>

            <div class="form-check">
                <label class="form-check-label" style="display: inline-block" for="hasSizes">Has Sizes?:</label>
                <input class="form-check-input"  type="checkbox" value="1" id="hasSizes" name="hasSizes">
            </div>
            <br/>
            <div id="sizes-section" style="display: none;">
                <h3>Sizes</h3>
                <div class="form-check">
                    <label class="form-check-label" style="display: inline-block" for="samePriceForAllSizes">Same Price for All Sizes?:</label>
                    <input class="form-check-input"  type="checkbox" value="1" id="samePriceForAllSizes" name="samePriceForAllSizes">
                </div>
                <div id="sizes-container">
                </div>

                <button class="btn btn-primary" type="button" onclick="addSizeField()">Add Size</button>
                <br/><br/><br/>

            </div>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required><br>

            <label for="image">Upload Image:</label>
            <input required type="file" id="image" name="image" accept="image/*"><br>
        
    
    
    
            </fieldset>
            
    
            <button  id="submitButton" type="submit">Add Product</button>
            
        </form>
    </div>
    <script>
        var index = 1;
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
        $(document).ready(function() {


            // Toggle sizes section visibility
            $('#hasSizes').change(function() {
                $('#sizes-section').toggle(this.checked);
                if(length == 0){
                    const container = $('#sizes-container');
                    const length = container.children().length;
                    var display = $('#samePriceForAllSizes').prop('checked') ? "none" : "block";
                    var required = $('#samePriceForAllSizes').prop('checked') ? "" : "required";
                    const div = `
                                <div>
                                    <label class="sizeLabels" style="display: inline-block; margin-bottom: 5px" for="size1">Size 1:</label>
                                    <button class="btn btn-danger" style="display: inline-block; margin-bottom: 5px" type="button" onclick="removeSizeField(this)">Remove</button>
                                    <br/>
                                    <input type="text" id="size1" name="sizes[0][size]" required>
                                    <div class="differentPrices" style="display: ${display}">
                                        <label class="pricelabels" for="price1">Price 1:</label>
                                        <input class="sizeprices" type="number" id="price1" name="sizes[0][price]" step="0.01" ${required}>
                                    </div>
                                </div>
                    `;
                    container.append(div);
                        }
                    });
                
    
            $('#samePriceForAllSizes').change(function() {
            $('.differentPrices').toggle(!this.checked);
            $('.sizeprices').attr('required', !this.checked);
        });
    
            // Initialize subcategory based on main category selection
            $('#mainCategory').change(function() {
                const categories = @json($categories);
                const selectedCategory = $(this).val();
                const mainCategory = categories.find(category => category.categoryName === selectedCategory);
                const subCategories = mainCategory ? mainCategory.subCategories : [];
    
                $('#subcategory_div').show();
                const $subCategory = $('#subCategory');
                $subCategory.empty(); // Clear previous options
    
                subCategories.forEach(element => {
                    $subCategory.append(`<option value="${element}">${element}</option>`);
                });
            });
        });
    
        // Add new size field
        function addSizeField() {
            const container = $('#sizes-container');
            // const index = container.children().length + 1;
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