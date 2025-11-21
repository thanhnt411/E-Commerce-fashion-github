@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slide</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="admin.slides">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="admin.slides.edit">
                            <div class="text-tiny">Slider</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Slide</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form method="POST" action="{{ route('admin.slides.update', $slides) }}"
                    class="form-new-product form-style-1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <fieldset class="name">
                        <div class="body-title">Tag line <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="tagline" name="tagline" tabindex="0"
                            value="{{ $slides->tagline }}" aria-required="true" required="">
                    </fieldset>
                    @error('tagline')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="title" name="title" tabindex="0"
                            value="{{ $slides->title }}" aria-required="true" required="">
                    </fieldset>
                    @error('title')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Sub Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="subtitle" name="subtitle" tabindex="0"
                            value="{{ $slides->subtitle }}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Link <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="link" name="link" tabindex="0"
                            value="{{ $slides->link }}" aria-required="true" required="">
                    </fieldset>
                    @error('link')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($slides->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('storage/' . $slides->image) }}" class="effect8" alt="">
                                </div>
                            @endif
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option>Select</option>
                                <option value="1" @selected($slides->status == '1')>Active</option>
                                <option value="0" @selected($slides->status == '0')>Inactive</option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Update</button>
                        <a href="{{ route('admin.slides') }}"
                            class="btn btn-secondary d-flex justify-content-center align-items-center fw-bold"
                            style="width: 120px; height: 50px; border-radius: 10px; font-size:16px">Cancle</a>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const photoInp = $("#myFile");
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
        });
    </script>
@endpush
