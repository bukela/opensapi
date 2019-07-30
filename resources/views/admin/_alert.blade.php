@if(session()->has('status'))
    @section('alert')
        <script>
            swal('{{session('status')['type']}}', '{{session('status')['message']}}', '{{session('status')['type']}}');
        </script>
    @endsection
@endif
