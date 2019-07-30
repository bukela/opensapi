@extends('layouts.admin')

@section('title')
    <i class="fas fa-handshake"></i> Donator
@endsection
@section('subtitle')
    {{__('Edit')}}
@endsection

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="news-update-form" action="{{ route('admin.donator.update', $donator->id) }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                        <label for="first_name">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $donator->name) }}">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name', $user->last_name) }}">
                        @if ($errors->has('last_name'))
                            <div class="text-danger">
                                {{ $errors->first('last_name') }}
                            </div>
                        @endif
                    </div> --}}

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $donator->email) }}">
                        @if ($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-check-label" for="active">{{ __('Active') }}&nbsp;</label>
                        <input type="checkbox" name="active" class="form-check-input"
                        {{$donator->active == 1 ? 'checked' : ''}}
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-check-label" for="moderator">{{ __('Moderator') }}&nbsp;</label>
                        <input type="checkbox" name="moderator" class="form-check-input"
                        {{$donator->moderator == 1 ? 'checked' : ''}}
                        >
                    </div>


                    <div class="form-group">
                        <label for="email">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password'))
                            <div class="text-danger">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password_confirmation'))
                            <div class="text-danger">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" id="editor" class="form-control">{{ old('description', $donator->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                            <img src="{{asset('uploads/avatars/' . $donator->avatar)}}" height="100">
                        <input name="avatar" type="file" accept="image/*">
                    </div>

                    <div class="form-group">
                        <a class="btn btn-danger" href="{{ route('admin.donators.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="news-update-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('admin._summernote')
@endsection
