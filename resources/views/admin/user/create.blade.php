@extends('layouts.admin')

@section('title')
    <i class="fas fa-users"></i> {{__('User')}}
@endsection
@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="news-update-form" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="form-group required">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}">
                        @if ($errors->has('last_name'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('last_name') }}
                            </div>
                        @endif
                    </div> --}}
                    <input type="text" name="user" style="display:none">
                    <div class="form-group required">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="invalid-feedback text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                    <input type="checkbox" name="active" class="form-check-input" {{ (! empty(old('active')) ? 'checked' : '') }}>
                    </div>

                    <div class="form-group">
                        <label class="form-check-label" for="moderator">{{ __('Moderator') }}&nbsp;</label>
                        <input type="checkbox" name="moderator" class="form-check-input" {{ (! empty(old('moderator')) ? 'checked' : '') }}>
                    </div>

                    {{--  <div class="form-group">
                        <label for="role_id">{{ __('Role') }}</label>
                        <select  id="role_select" name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>  --}}

                    {{-- <input type="number" name="role_id" style="display:none" value="4"> --}}

                    <div class="form-group required">
                    <label for="selector">{{ __('User Belongs To :') }}</label>
                    </div>

                    <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input radio-select-don" type="radio" name="donator" value="donator">
                                <label class="form-check-label" for="donator">
                                        {{__('Donator')}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input radio-select-org" type="radio" name="organization" value="org">
                                <label class="form-check-label" for="org">
                                    {{__('Organization')}}
                                </label>
                            </div>
                    </div>

                    <div id="org_select" class="form-group">
                        <label for="organization">{{ __('Organization') }}</label>
                        
                        <select id="organization_selector" name="organization" class="form-control">
                            <option value="" selected>{{ __('Choose Organization') }}</option>
                            @foreach ($organizations as $org)
                                <option value="{{ $org->id }}">{{ $org->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    {{-- @if ($errors->has('organization'))
                            <div class="text-danger">
                                {{ $errors->first('organization')}}
                            </div>
                            @endif --}}
                            @if ($errors->has('donator') || $errors->has('organization'))
                            <div class="text-danger">
                                {{-- {{ $errors->first('donator')}}
                                {{ $errors->first('organization')}} --}}
                            <span>{{ __('Choose Donator or Organization') }}</span>
                            </div>
                        @endif
                    <div id="donator_select" class="form-group">
                        <label for="donator">{{ __('Donator') }}</label>
                        
                        <select id="donator_selector" name="donator" class="form-control">
                            <option value="" selected>{{ __('Choose Donator') }}</option>
                            @foreach ($donators as $don)
                                <option value="{{ $don->id }}">{{ $don->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    {{-- <div class="errors-select form-group">
                            @if ($errors->has('donator'))
                            <div class="text-danger">
                                {{ $errors->first('donator')}}
                            </div>
                            @endif
                    </div> --}}
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" id="editor" rows="5" class="form-control" >{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar</label>
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
                        <a class="btn btn-danger" href="{{ route('admin.users.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="news-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- @include('admin._summernote') --}}
    {{--  @include('admin._organization')  --}}
    {{--  @include('admin._donator')  --}}
    @include('admin._radio-select')
@endsection
