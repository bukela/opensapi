@extends('layouts.admin')

@section('title')
    <i class="fas fa-forward"></i> {{__('Cost')}}
@endsection
@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="create-project-form" action="{{ route('admin.cost.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group required">
                        <label for="approved_funds">{{__('Cost Category')}}</label>
                        <select name="category_id" class="form-control">
                                <option value="">{{__('Choose Cost Category')}}</option>
                            @foreach ($categories as $category)
                            @if(isset($category->project->id) && $category->project->id == basename(request()->path()))
                                {{-- <option value="" selected disabled hidden>Choose Cost Category</option> --}}
                                <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}    
                                >{{ $category->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                            <div class="form-check">
                                
                                <label>
                                <input class="form-check-input" type="radio" name="type" value="donator" checked> {{__('Donator Funds')}}
                                </label>
                            </div>
                            <div class="form-check">
                                <label>
                                <input class="form-check-input" type="radio" name="type" value="personal"> {{__('Personal Funds')}}
                                </label>
                            </div>
                    </div> --}}

                    {{-- <div class="form-group required">
                        <label for=spent">{{__('Spent')}}</label>
                        <input type="text" name="spent" class="form-control{{ $errors->has('spent') ? ' is-invalid' : '' }}" value="{{ old('spent') }}">
                        @if ($errors->has('spent'))
                            <div class="text-danger">
                                {{ $errors->first('spent') }}
                            </div>
                        @endif
                    </div> --}}

                    <div class="form-group">
                        <label for=spent_donator">{{__('Spent Donator')}}</label>
                        <input type="text" name="spent_donator" class="form-control{{ $errors->has('spent_donator') ? ' is-invalid' : '' }}" value="{{ old('spent_donator') }}">
                        @if ($errors->has('spent_donator'))
                            <div class="text-danger">
                                {{ $errors->first('spent_donator') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for=spent_private">{{__('Spent Private')}}</label>
                        <input type="text" name="spent_private" class="form-control{{ $errors->has('spent_private') ? ' is-invalid' : '' }}" value="{{ old('spent_private') }}">
                        @if ($errors->has('spent_private'))
                            <div class="text-danger">
                                {{ $errors->first('spent_private') }}
                            </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                    <label for="cost_type">{{ __('Cost type') }}</label>
                        <div class="form-check">
                            
                            <label>
                            <input class="form-check-input" type="radio" name="type" value="donator" checked> {{__('Donator Funds')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label>
                            <input class="form-check-input" type="radio" name="type" value="private"> {{__('Personal Funds')}}
                            </label>
                        </div>
                </div> --}}

                    <div class="form-group" style="display:none">
                        <input type="text" name="project_id" value="{{ basename(request()->path()) }}">
                    </div>

                    <div class="form-group required">
                        <label for="description">{{__('Description')}}</label>
                    <textarea name="description" rows="3" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-danger">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for=invoice_number">{{__('Invoice Number')}}</label>
                        <input type="text" name="invoice_number" class="form-control{{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" value="{{ old('invoice_number') }}">
                        @if ($errors->has('invoice_number'))
                            <div class="text-danger">
                                {{ $errors->first('invoice_number') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="payment_date">{{ __('Payment Date') }} <i class="fas fa-calendar-alt"></i></label>
                        <div class="control">
                            <input class="date" name="payment_date" type="date" placeholder="{{__('Payment Date')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note">{{__('Note')}}</label>
                    <textarea name="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                    </div>

                    

                    {{-- <div class="form-group">
                        <label class="form-check-label" for="approved">{{ __('Approved') }}&nbsp;</label>
                        <input type="checkbox" name="approved" class="form-check-input">
                    </div> --}}

                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        
                        <select name="status" class="form-control">
                            <option value="pending" selected>{{ __('Pending') }}</option>
                            <option value="approved">{{ __('Approved') }}</option>
                            <option value="rejected">{{ __('Rejected') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="document">{{__('Document')}}</label>
                        <input name="file" type="file" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{ route('admin.project.show', ['id' => basename(request()->path())]) }}"><i class="fas fa-times-circle"></i> {{__('Cancel')}}</a>
                        <button type="submit" form="create-project-form" class="btn btn-success"><i class="fas fa-save"></i> {{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
