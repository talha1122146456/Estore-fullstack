<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 20px;">
        <label>Current Media:</label>
        <div style="width: 200px; height: 150px; border: 1px solid #ddd; margin-top: 10px;">
            @if($product->video)
                <video width="100%" height="100%" controls>
                    <source src="{{ asset('uploads/products/videos/'.$product->video) }}" type="video/mp4">
                </video>
            @elseif($product->image)
                <img src="{{ asset('uploads/products/'.$product->image) }}" style="width:100%; height:100%; object-fit:cover;">
            @endif
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Replace Video (Optional):</label>
        <input type="file" name="video" class="form-control" accept="video/mp4">
    </div>

    <div style="margin-bottom: 15px;">
        <label>Replace Image (Optional):</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
        Update Product
    </button>
</form>