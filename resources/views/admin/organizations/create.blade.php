@extends('layouts.admin')

@section('title')
    <i class="fas fa-building"></i> {{__('Organization')}}
@endsection
@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
@if($errors->has())
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
@endif
<div class="col-md-4 col-md-offset-4">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="news-create-form" action="{{ route('admin.organization.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" checked="checked">
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="moderator">{{ __('Moderator') }}&nbsp;</label>
                    <input type="checkbox" name="moderator" class="form-check-input">
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                <textarea rows="3" class="form-control" name="description">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="avatar">{{ __('Avatar') }}</label>
                    <input name="avatar" type="file" accept="image/*">
                    @if ($errors->has('avatar'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.organizations.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="news-create-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
