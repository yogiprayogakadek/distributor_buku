@extends('templates.master')

@section('title', 'Distribusi')
@section('sub-title', 'Data')

@section('content')
<div class="row">
    <div class="col-12 render">
        {{-- render --}}
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('assets/functions/distribusi/main.js')}}"></script>
@endpush
