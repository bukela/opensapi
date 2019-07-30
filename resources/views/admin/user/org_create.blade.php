@extends('layouts.admin')

@section('title')
    <i class="fas fa-building"></i> {{__('Organization')}}
@endsection

@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <div class="row">
            <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                {{ csrf_field() }}
                <div class="form-group required">
                    <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group required">
                    <label for="email">{{ __('Email') }}</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
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

                <div class="form-group" style="display:none">
                    {{-- <label class="form-check-label" for="moderator">{{ __('Moderator') }}&nbsp;</label> --}}
                    <input type="checkbox" name="moderator" class="form-check-input" checked>
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                <textarea rows="5" class="form-control" name="description">{{ old('description') }}</textarea>
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

                <div class="form-group required">
                    <label for="email">{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback text-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <input type="number" name="role_id" style="display:none" value="3">

                <div class="form-group required">
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
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>

                
                </div>
                {{--  <div class="col-md-6">
                        <div class="form-group required">
                                <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <div class="invalid-feedback text-danger">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                        </div>

                        <div class="form-group required">
                                <label for="address">{{ __('Address') }}</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback text-danger">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                        </div>

                        <div class="form-group required">
                                <label for="bank_account">{{ __('Account') }}</label>
                            <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}">
                                @if ($errors->has('bank_account'))
                                    <div class="invalid-feedback text-danger">
                                        {{ $errors->first('bank_account') }}
                                    </div>
                                @endif
                        </div>
                        
                        <div class="form-group required">
                                <label for="pib">{{ __('PIB') }}</label>
                            <input type="text" name="pib" class="form-control" value="{{ old('pib') }}">
                                @if ($errors->has('pib'))
                                    <div class="invalid-feedback text-danger">
                                        {{ $errors->first('pib') }}
                                    </div>
                                @endif
                        </div>
                </div>  --}}
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
