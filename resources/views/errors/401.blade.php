@extends('layouts.app')

@section('title', 'Tidak Terautentikasi')

@section('content')
<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;">
    <h1 style="font-size:4rem;color:#dc2626;margin-bottom:1rem;">401</h1>
    <h2 style="font-size:2rem;color:#333;margin-bottom:1rem;">Tidak Terautentikasi</h2>
    <p style="font-size:1.2rem;color:#666;margin-bottom:2rem;">
        Anda harus login untuk mengakses halaman ini.<br>
        Silakan login terlebih dahulu.
    </p>
    <a href="/login" style="padding:0.75rem 2rem;background:#2563eb;color:#fff;border-radius:8px;text-decoration:none;font-weight:600;">Login</a>
</div>
@endsection
