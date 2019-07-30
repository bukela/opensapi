@extends('layouts.admin')

@section('title')
    <i class="fas fa-file"></i> {{__('Category')}}
@endsection

@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <form id="category-create-form" action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{-- <div class="col-md-6"> --}}
                    <div class="form-group required">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('name'))
                            <div class="text-danger invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                {{-- </div> --}}

                <div class="form-group" style="display:none">
                    <input type="text" name="project_id" value="{{ basename(request()->path()) }}">
                </div>

                {{-- <div class="col-md-6"> --}}
                    <div class="form-group">
                        <label for="approved_for_category">{{ __('Approved Donator Funds') }}</label>
                        <input type="text" name="approved_for_category" value="{{ old('approved_for_category') }}" class="form-control {{ $errors->has('approved_for_category') ? ' is-invalid' : '' }}">
                        @if ($errors->has('approved_for_category'))
                            <div class="text-danger invalid-feedback">
                                {{ $errors->first('approved_for_category') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="approved_for_category_private">{{ __('Approved Private Funds') }}</label>
                        <input type="text" name="approved_for_category_private" value="{{ old('approved_for_category_private') }}" class="form-control {{ $errors->has('approved_for_category_private') ? ' is-invalid' : '' }}">
                        @if ($errors->has('approved_for_category_private'))
                            <div class="text-danger invalid-feedback">
                                {{ $errors->first('approved_for_category_private') }}
                            </div>
                        @endif
                    </div>
                {{-- </div> --}}
                {{-- <div class="col-md-6"> --}}
                <div class="form-group">
                        <div class="form-check">
                            
                            <label>
                            <input class="form-check-input" type="radio" name="direct_cost" value="1" checked> {{__('Direct Cost')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label>
                            <input class="form-check-input" type="radio" name="direct_cost" value="0"> {{__('Indirect Cost')}}
                            </label>
                        </div>
                </div>
                    {{-- </div> --}}
                <div class="form-group">
                    <a class="btn btn-danger" href="{{ route('admin.projects.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                    <button type="submit" form="category-create-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
