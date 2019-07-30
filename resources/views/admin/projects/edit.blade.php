@extends('layouts.admin')

@section('title')
    <i class="fas fa-forward"></i> {{__('Project')}}
@endsection
@section('subtitle')
    {{__('Edit')}}
@endsection

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="update-project-form" action="{{ route('admin.project.update', $project->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                    <div class="form-group required">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $project->title }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group required">
                        <label for="organization">{{ __('Organization') }}</label>
                        <select name="organization_id" class="form-control">
                                @foreach ($organizations as $org)
                                <option value="{{ $org->id }}"
                                    @if( $project->organization_id == $org->id )
                                        selected
                                    @endif    
                                >{{ $org->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('organization_id'))
                            <div class="text-danger">
                                {{ $errors->first('organization_id') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group required">
                        <label for="donator">{{ __('Choose Donator') }}</label>
                    </div>
                    <div class="form-group">
                            
                            @foreach ($donators as $donator)
                            <div class="radio">
                            <img src="{{ !$donator->avatar==null ? asset('/uploads/avatars/'.$donator->avatar) : asset('/img/no-image.png') }}" alt="donator-logo" width="60">
                            <label><input class="form-control" type="radio" name="donator_id" value="{{ $donator->id }}"
                                @if($project->donator_id == $donator->id)
                                    checked 
                                @endif
                                ></label>
                                <span>{{ $donator->name }}</span>
                            </div>
                            @endforeach
                            @if ($errors->has('donator_id'))
                            <div class="text-danger">
                                {{ $errors->first('donator_id') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                        <label for=approved_funds">{{ __('Approved Funds') }}</label>
                        <input type="text" name="approved_funds" class="form-control{{ $errors->has('approved_funds') ? ' is-invalid' : '' }}" value="{{ $project->approved_funds }}">
                        @if ($errors->has('approved_funds'))
                            <div class="text-danger">
                                {{ $errors->first('approved_funds') }}
                            </div>
                        @endif
                    </div> --}}

                    {{-- <div class="form-group">
                        <label for="approved_funds">{{ __('Approved Funds By Category') }}</label>
                    </div> --}}

    {{-- @foreach ($project->categories as $pro)
        {{dd($pro->pivot->approved_for_category)}}
    @endforeach     --}}

                    {{-- <div class="form-group">
                        @foreach ($project->categories as $pro)
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $pro->name }}" name="name[]" required>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="category_id[]" class="form-control" value="{{ $pro->id }}" >
                            <input type="number" name="approved_for_category[]" class="form-control" value="{{ $pro->approved_for_category }}">
                            <a class="delete__confirm" href="{{ route('admin.category.destroy', $pro->id) }}"><i class="fas fa-trash"></i></a>
                        </div>
                            
                        @endforeach
                    </div> --}}

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" rows="5" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" >{{ $project->description }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>


                    {{-- <div class="form-group">
                        <label for="image">Image</label>
                        <input name="image" type="file" accept="image/*">
                    </div> --}}

                    {{-- <div class="form-check">
                        <input type="hidden" name="url_new_window" value="0">
                        <input type="checkbox" class="form-check-input" name="url_new_window" id="url_new_window" value="1">
                        <label class="form-check-label" for="url_new_window">Open link in new window/tab</label>
                    </div> --}}
                    <br>
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{ route('admin.projects.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="update-project-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
