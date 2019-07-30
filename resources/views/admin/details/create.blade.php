
                @extends('layouts.admin')

                @section('title')
                    <i class="fas fa-building"></i> {{__('Details')}}
                @endsection
                @section('subtitle')
                    {{__('Create')}}
                @endsection
                
                @section('content')
                <div class="col-md-6 col-md-offset-3">
                    <div class="block block-rounded block-bordered">
                        <div class="block-content">
                            <form action="{{ route('admin.detail.store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                        <label for="phone">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <div class="invalid-feedback text-danger">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                </div>
        
                                <div class="form-group hidden">
                                    <input type="text" name="user_id" value="{{ basename(request()->path()) }}">
                                </div>
                                <div class="form-group">
                                        <label for="address">{{ __('Address') }}</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                        @if ($errors->has('address'))
                                            <div class="invalid-feedback text-danger">
                                                {{ $errors->first('address') }}
                                            </div>
                                        @endif
                                </div>
        
                                <div class="form-group">
                                        <label for="bank_account">{{ __('Account') }}</label>
                                    <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}">
                                        @if ($errors->has('bank_account'))
                                            <div class="invalid-feedback text-danger">
                                                {{ $errors->first('bank_account') }}
                                            </div>
                                        @endif
                                </div>
                                
                                <div class="form-group">
                                        <label for="pib">{{ __('PIB') }}</label>
                                    <input type="text" name="pib" class="form-control" value="{{ old('pib') }}">
                                        @if ($errors->has('pib'))
                                            <div class="invalid-feedback text-danger">
                                                {{ $errors->first('pib') }}
                                            </div>
                                        @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="invalid-feedback text-danger">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <a class="btn btn-danger" href="{{ route('admin.organizations.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endsection