@extends('layouts.admin')

@section('title')
    <i class="fas fa-building"></i> {{__('Organization')}}
@endsection

@section('subtitle')
    {{__('Edit')}}
@endsection

@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="organization-update-form" action="{{ route('admin.organization.update', ['organization' => $organization->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control input-lg{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $organization->name }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $organization->email) }}">
                        @if ($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input"
                    {{$organization->active == 1 ? 'checked' : ''}}
                    >
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="moderator">{{ __('Moderator') }}&nbsp;</label>
                    <input type="checkbox" name="moderator" class="form-check-input"
                    {{$organization->moderator == 1 ? 'checked' : ''}}
                    >
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                <textarea rows="3" class="form-control" name="description">{{ $organization->description }}</textarea>
                </div>
                
                <div class="form-group">
                    @if ($organization->avatar)
                        <img src="{{asset('uploads/avatars/' . $organization->avatar)}}" height="100">
                    @endif
                    <label for="avatar">{{ __('Avatar') }}</label>
                    <input name="avatar" type="file" accept="image/*">
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
                    @if ($errors->has('password_confirmation'))`
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.organizations.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="organization-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
