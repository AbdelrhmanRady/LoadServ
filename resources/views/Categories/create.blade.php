
@extends("layouts.app")
@section("title") Add Category @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/AddCategory.css') }}">

<script>
    let subCategoryCount = 1;

    function updateSubCategoryLabels() {
            const labels = document.querySelectorAll('.sub-category-label');
            labels.forEach((label, index) => {
                label.innerHTML = 'Subcategory ' + (index + 1) + ':';
            });
        }

        function addSubCategoryField() {
            const subCategoryContainer = document.getElementById('sub-category-container');

            const div = document.createElement('div');
            div.className = 'sub-category-group';

            const label = document.createElement('label');
            label.className = 'sub-category-label';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'sub_categories[]';
            input.className = 'form-control';

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'remove-sub-category';
            button.innerHTML = 'X';
            button.onclick = function() {
                subCategoryContainer.removeChild(div);
                updateSubCategoryLabels();
            };

            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(button);

            subCategoryContainer.appendChild(div);
            updateSubCategoryLabels();
        }
    </script>
</script>

<div class="AddListing">
    <form class="AddListing-form" method="POST" action="{{route("categories.create")}}">
        @csrf
        <h1>Add Category</h1>
        
        <fieldset>
        
        <legend style="font-size: 250%; font-weight: bold;"> Category info</legend>
        
        <label for="name">Name:</label>
        <input  type="text" id="name" name="Category_Name" required/>
        <label style="font-size: 250%; font-weight: normal;">Sub-Categories:</label>
        <div id="sub-category-container">
            <div class="sub-category-group">
                <label class="sub-category-label">Subcategory 1:</label>
                <input type="text" name="sub_categories[]" class="form-control">
            </div>
        </div>
        <button type="button" onclick="addSubCategoryField()">Add Sub-Category</button>

        </fieldset>
        

        
        <button type="submit">Submit</button>
        
    </form>
</div>
@endsection
