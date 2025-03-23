@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Masyarakat</h1>
    <a href="{{ route('masyarakat.pengaduan.create') }}" class="btn btn-primary mt-3">Input Pengaduan</a>
    <br>
    <a href="{{ route('masyarakat.pengaduan.index') }}" class="btn btn-primary mt-3">Daftar Pengaduan</a>
</div>
@endsection
