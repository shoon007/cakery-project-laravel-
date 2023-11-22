@extends('admin.layouts.master')
@section('content')
    {{-- product update page --}}
    <div class="main">

        <button class="back-btn" onclick="history.back()">
            <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
                <path
                    d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
                </path>
            </svg>
            <span>Back</span>
        </button>

        <h1 class="text-center mb-4">Update Product</h1>

        <div class="edit-container">
            <form action="{{ route('product#update') }}" method="post" enctype="multipart/form-data" class="edit-form">
                @csrf
                <div class="profile-div">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="img-thumbnail post-img"
                        id="profile-img">
                    <div class="upload">
                        <input type="file" id="real-file" hidden="hidden" name="image"
                            onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" />
                        <button type="button" id="custom-button">choose a picture </button>
                    </div>
                    @error('image')
                        <small class="text-danger ms-2 mt-2 d-block">{{ $message }}</small>
                    @enderror

                </div>

                <div class="d-flex flex-column align-content-center justify-content-center">
                    <div class="inputs-container">
                        <div class="inputs">
                            <label for="">Name<br>
                                <input type="text" placeholder="Enter name" name="postName"
                                    value="{{ old('postName', $product->name) }}" id="name">
                                @error('postName')
                                    <small class="text-danger ms-2 d-block">{{ $message }}</small>
                                @enderror
                                <input type="hidden" name="id" value="{{ $product->id }}">
                            </label>

                            <label for="" class="move">Category
                                <select name="category" class="form-select my-custom-select"
                                    aria-label="Default select example">
                                    <option value="">Choose one </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category', $category->id) == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <small class="text-danger ms-2 d-block">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        <div class="inputs">
                            <label for="">Description<br>
                                <textarea id="textarea" cols="30" rows="4" name="description" placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <small class="text-danger ms-2 d-block">{{ $message }}</small>
                                @enderror
                            </label>

                            <label for="">Price<br>
                                <input type="text" placeholder="Enter price" name="price"
                                    value="{{ old('price', $product->price) }}">
                                @error('price')
                                    <small class="text-danger ms-2 d-block">{{ $message }}</small>
                                @enderror
                            </label>

                        </div>
                    </div>
                    <button class="button mt-3">Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
