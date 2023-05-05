@extends('templates.master')

@section('title', 'Buku')
@section('sub-title', 'Data')

@section('content')
<div class="row">
    <div class="col-12 render">
        {{-- render --}}
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('assets/functions/buku/main.js')}}"></script>
@endpush
