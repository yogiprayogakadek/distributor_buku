@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
    <div class="row render">
        {{--  --}}
    </div>
@endsection

@push('script')
    <script>
        function assets(url) {
            var url = '{{ url('') }}/' + url;
            return url;
        }
    </script>
    <script src="{{ asset('assets/functions/transaksi/main.js') }}"></script>
@endpush
