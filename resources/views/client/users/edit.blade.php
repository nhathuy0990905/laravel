@extends('layouts.client')
@section('title')
    {{$title}}
@endsection

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            Dữ liệu nhập vào không hợp lệ
        </div>
    @endif

    <h1 style="text-align: center">{{$title}}</h1>
    <form action="{{route('users.post-edit')}}" method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" class="form-control" name="fullname" placeholder="Nhập tên..." value="{{old('fullname') ?? $userDetail->fullname}}">
            @error('fullname')
                <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="text" class="form-control" name="email" placeholder="Nhập email..." value="{{old('fullname') ?? $userDetail->fullname}}">
            @error('email')
                <span style="color: red">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{route('users.index')}}" class="btn btn-warning">Quay lại</a>
        @csrf
    </form>
@endsection