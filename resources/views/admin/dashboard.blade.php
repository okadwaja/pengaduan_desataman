@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary mt-3">Daftar Pengaduan</a>
</div>
@endsection
