@extends('layouts.admin')

@section('title')
    <i class="fas fa-address-book"></i> {{__('Contact Us')}}
@endsection
{{-- @section('subtitle')
    {{__('contact form')}}
@endsection --}}
@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="contactus-form" action="{{ route('admin.contactus.store') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group required">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group required">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="text-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group required">
                    <label for="message">{{ __('Message') }}</label>
                    <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <div class="text-danger">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.dashboard') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="contactus-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Send') }}</button>
                </div>
            </div> 
            </form>
        </div>
    </div>
</div>


@endsection

