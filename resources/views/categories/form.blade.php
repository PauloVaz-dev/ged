<div class="card-body">

    <div class="form-group">
        <select class="form-control" name="parent_id">
            <option value="">Select Parent Category</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Category Name" required>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
</div>

