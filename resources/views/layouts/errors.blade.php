@if ($errors->any())
<div class="alert error-holder">
    <ul>
        @foreach ($errors->all() as $error)
        <li class="has-text-danger">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif