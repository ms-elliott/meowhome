@extends('layouts.common')

@section('title', '募集投稿')
@section('content')
<section class="py-8">
    <div class="container px-4 mx-auto">
        <div class="py-4 px-4 bg-white rounded">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="flex px-6 pb-4 border-b">
                    <h3 class="text-xl font-bold">里親募集 新規投稿</h3>
                </div>

                <div class="pt-2 mx-2">
                    <!-- ▼▼▼▼エラーメッセージ▼▼▼▼　-->
                    @if($errors->any())
                    <div class="mb-4 py-3 px-6 alert alert-danger rounded">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li style="color: red;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- ▲▲▲▲エラーメッセージ▲▲▲▲　-->
                    <input type="hidden" id="status" name="status" value="0">
                    <div class="row align-items-center">
                        <label class="col-xl-2 text-sm font-medium text-xl-end mb-2">年齢(推定)<span class="badge text-bg-primary ms-2">必須</span></label>
                        <div class="col-xl-3 d-flex align-items-center mb-2">
                            <input id="age_year" class="form-control text-sm bg-white border rounded text-end" type="text" name="age_year" value="{{ old('age_year', 0) }}" style="width: 60px;">
                            <label class="text-sm font-medium mx-1" for="age-year">歳</label>
                            <input id="age_month" class="form-control text-sm bg-white border rounded text-end" type="text" name="age_month" value="{{ old('age_month', 0) }}" style="width: 60px;">
                            <label class="text-sm font-medium ms-1" for="age-month" style="width: 70px;">ヶ月</label>
                        </div>
                        <label class="col-xl-2 text-sm font-medium text-xl-end mb-2">性別<span class="badge text-bg-primary ms-2">必須</span></label>
                        <div class="col-xl-2 mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="0" {{ old('gender') == "0" ? 'checked' : ''}}>
                                <label class="form-check-label" for="male">オス</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="1" {{ old('gender') == "1" ? 'checked' : ''}}>
                                <label class="form-check-label" for="female">メス</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <label class="col-xl-2 text-sm font-medium text-xl-end" for="breed_id">種類</label>
                        <div class="col-md-5 col-xl-2 my-2">
                            <select id="breed_id" class="form-select" aria-label="breed" name="breed_id">
                                <option class="bg-white" value="0" selected>未選択</option>
                                @foreach ($breeds as $breed)
                                <option class="bg-white" value="{{ $breed->id }}" @if($breed->id === (int)old('breed_id')) selected @endif > {{ $breed->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-xl-3 text-sm font-medium text-xl-end" for="pattern_id">毛柄</label>
                        <div class="col-md-5 col-xl-2 my-2">
                            <select id="pattern_id" class="form-select" aria-label="pattern" name="pattern_id">
                                <option class="bg-white" value="0" selected>未選択</option>
                                @foreach ($patterns as $pattern)
                                <option class="bg-white" value="{{ $pattern->id }}" @if($pattern->id === (int)old('pattern_id')) selected @endif > {{ $pattern->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <label class="col-xl-2 text-sm font-medium text-xl-end">ワクチン接種<span class="badge text-bg-primary ms-2">必須</span></label>
                        <div class="col-xl-2 my-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="vaccined" id="vaccined_false" value="0" {{ old('vaccined') == "0" ? 'checked' : ''}}>
                                <label class="form-check-label" for="vaccined_false">未</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="vaccined" id="vaccined_true" value="1" {{ old('vaccined') == "1" ? 'checked' : ''}}>
                                <label class="form-check-label" for="vaccined_true">済</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="vaccined" id="vaccined_unknow" value="9" {{ old('vaccined') == "9" ? 'checked' : ''}}>
                                <label class="form-check-label" for="vaccined_unknown">不明</label>
                            </div>
                        </div>
                        <label class="col-xl-3 text-sm font-medium text-xl-end">去勢/避妊手術<span class="badge text-bg-primary ms-2">必須</span></label>
                        <div class="col-xl-2 my-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="neutered" id="neutered_false" value="0" {{ old('neutered') == "0" ? 'checked' : ''}}>
                                <label class="form-check-label" for="neutered_false">未</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="neutered" id="neutered_true" value="1" {{ old('neutered') == "1" ? 'checked' : ''}}>
                                <label class="form-check-label" for="neutered_true">済</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="neutered" id="neutered_unknown" value="9" {{ old('neutered') == "9" ? 'checked' : ''}}>
                                <label class="form-check-label" for="neutered_unknown">不明</label>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <label class="col-xl-2 text-sm font-medium text-xl-end mb-xl-3" for="location_id">所在地<span class="badge text-bg-primary ms-2">必須</span></label>
                        <div class="col-6 col-md-3 col-xl-2 my-2 mb-3">
                            <select id="location_id" class="form-select" aria-label="location_id" name="location_id">
                                @foreach ($locations as $location)
                                <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('location_id', $user->location_id)) selected @endif > {{ $location->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-xl-4 d-flex">
                            <label class="text-sm font-medium text-xl-end ms-xl-5 mb-3">単身者応募<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="ms-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="accept_single" id="single_is_accepted" value="1" {{ old('accept_single') == "1" ? 'checked' : ''}}>
                                    <label class="form-check-label" for="single_is_accepted">可</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="accept_single" id="single_is_rejected" value="0" {{ old('accept_single') == "0" ? 'checked' : ''}}>
                                    <label class="form-check-label" for="single_is_rejected">不可</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4 d-flex mb-3">
                            <label class="text-sm font-medium text-xl-end">高齢者応募<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="ms-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="accept_senior" id="senior_is_accepted" value="1" {{ old('accept_senior') == "1" ? 'checked' : ''}}>
                                    <label class="form-check-label" for="senior_is_accepted">可</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="accept_senior" id="senior_is_rejected" value="0" {{ old('accept_senior') == "0" ? 'checked' : ''}}>
                                    <label class="form-check-label" for="senior_is_rejected">不可</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center">
                        <div class="col-xl-2 text-sm font-medium text-xl-end">
                            <p class="mb-1">応募可能地域</p>
                        </div>
                        <div class="col-12 col-xl-2 d-flex justify-content-start mb-1">
                            <div class="d-flex align-items-center me-4">
                                <label class="ext-sm font-medium me-2" for="accept_location1">1</label>
                                <select id="accept_location1" class="form-select" aria-label="location" name="accept_location1" style="width: 130px;">
                                    <option class="bg-white" value="0" selected>未選択</option>
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('accept_location1')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-2 d-flex justify-content-start mb-1">
                            <div class="d-flex align-items-center me-4">
                                <label class="ext-sm font-medium me-2" for="accept_location2">2</label>
                                <select id="accept_location2" class="form-select" aria-label="location" name="accept_location2" style="width: 130px;">
                                    <option class="bg-white" value="0" selected>未選択</option>
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('accept_location2')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-2 d-flex justify-content-start mb-1">
                            <div class="d-flex align-items-center me-4">
                                <label class="ext-sm font-medium me-2" for="accept_location3">3</label>
                                <select id="accept_location3" class="form-select" aria-label="location" name="accept_location3" style="width: 130px;">
                                    <option class="bg-white" value="0" selected>未選択</option>
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('accept_location3')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-2 d-flex justify-content-start mb-1">
                            <div class="d-flex align-items-center me-4">
                                <label class="ext-sm font-medium me-2" for="accept_location4">4</label>
                                <select id="accept_location4" class="form-select" aria-label="location" name="accept_location4" style="width: 130px;">
                                    <option class="bg-white" value="0" selected>未選択</option>
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('accept_location4')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-2 d-flex justify-content-start mb-1">
                            <div class="d-flex align-items-center me-4">
                                <label class="ext-sm font-medium me-2" for="accept_location5">5</label>
                                <select id="accept_location5" class="form-select" aria-label="location" name="accept_location5" style="width: 130px;">
                                    <option class="bg-white" value="0" selected>未選択</option>
                                    @foreach ($locations as $location)
                                    <option class="bg-white" value="{{ $location->id }}" @if($location->id === (int)old('accept_location5')) selected @endif > {{ $location->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-xl-5 text-xl-end">
                                <p style="font-size: small;">※所在地を除く、最大５都道府県まで選択可能</p>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <label class="col-xl-2 text-sm font-medium text-xl-end" for="title">タイトル<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-12 col-xl-9 my-2">
                                <input id="title" class="form-control text-sm bg-white border rounded" type="text" name="title" value="{{ old('title') }}">
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label class="col-xl-2 text-sm font-medium text-xl-end mt-xl-2" for="body">本文<span class="badge text-bg-primary ms-2">必須</span></label>
                            <div class="col-xl-9 my-2">
                                <textarea id="body" class="col-12 block py-1 px-2 w-full mb-4 text-sm bg-white border rounded" name="body" rows="10">{{ old('body') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label class="col-xl-2 text-sm font-medium text-xl-end">写真</label>
                            <div class="col-12 col-xl-3 d-flex justify-content-start">
                                <div class="me-2">
                                    <label class="text-sm font-medium mb-2" for="photo1">１枚目<span class="badge text-bg-primary ms-2">必須</span></label>
                                    <div>
                                        <img id="previewImage1" data-noimage="storage/posts/post_no-image.png" alt="" class="rounded shadow-md object-fit-cover" height="200" width="200"
                                            src="{{ old('photo1') ? asset(old('photo1')) : (session()->has('uploadedPhoto1Path') ? asset(session('uploadedPhoto1Path')) : asset('storage/posts/post_no-image.png')) }}">
                                    </div>
                                    <input id="photo1" class="block w-full py-2" type="file" accept='image/*' name="photo1">
                                </div>
                            </div>
                            <div class="col-12 col-xl-3 d-flex justify-content-start">
                                <div class="me-2">
                                    <label class="text-sm font-medium" for="photo2">２枚目</label>
                                    <div>
                                        <img id="previewImage2" data-noimage="storage/posts/post_no-image.png" alt="" class="rounded shadow-md object-fit-cover" height="200" width="200"
                                            src="{{ old('photo2') ? asset(old('photo2')) : (session()->has('uploadedPhoto2Path') ? asset(session('uploadedPhoto2Path')) : asset('storage/posts/post_no-image.png')) }}">
                                    </div>
                                    <input id="photo2" class="block w-full py-2" type="file" accept='image/*' name="photo2">
                                </div>
                            </div>
                            <div class="col-12 col-xl-3 d-flex justify-content-start">
                                <div class="me-2">
                                    <label class="text-sm font-medium" for="photo3">３枚目</label>
                                    <div>
                                        <img id="previewImage3" data-noimage="storage/posts/post_no-image.png" alt="" class="rounded shadow-md object-fit-cover" height="200" width="200"
                                            src="{{ old('photo3') ? asset(old('photo3')) : (session()->has('uploadedPhoto3Path') ? asset(session('uploadedPhoto3Path')) : asset('storage/posts/post_no-image.png')) }}">
                                    </div>
                                    <input id="photo3" class="block w-full py-2" type="file" accept='image/*' name="photo3">
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-secondary py-2 px-4">投稿する</button>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('photo1').addEventListener('change', e => {
                        const previewImageNode = document.getElementById('previewImage1')
                        const fileReader = new FileReader()
                        fileReader.onload = () => previewImageNode.src = fileReader.result
                        if (e.target.files.length > 0) {
                            fileReader.readAsDataURL(e.target.files[0])
                        } else {
                            previewImageNode.src = previewImageNode.dataset.noimage
                        }
                    })
                </script>
                <script>
                    document.getElementById('photo2').addEventListener('change', e => {
                        const previewImageNode = document.getElementById('previewImage2')
                        const fileReader = new FileReader()
                        fileReader.onload = () => previewImageNode.src = fileReader.result
                        if (e.target.files.length > 0) {
                            fileReader.readAsDataURL(e.target.files[0])
                        } else {
                            previewImageNode.src = previewImageNode.dataset.noimage
                        }
                    })
                </script>
                <script>
                    document.getElementById('photo3').addEventListener('change', e => {
                        const previewImageNode = document.getElementById('previewImage3')
                        const fileReader = new FileReader()
                        fileReader.onload = () => previewImageNode.src = fileReader.result
                        if (e.target.files.length > 0) {
                            fileReader.readAsDataURL(e.target.files[0])
                        } else {
                            previewImageNode.src = previewImageNode.dataset.noimage
                        }
                    })
                </script>
            </form>
        </div>
    </div>
</section>
@endsection