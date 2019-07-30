@extends('layouts.admin')

@section('title')
    <i class="fas fa-forward"></i> {{__('Project')}}
@endsection
@section('subtitle')
    {{__('Create')}}
@endsection

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <form id="create-project-form" action="{{ route('admin.project.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group required">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <div class="text-danger">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group required">
                        <label for="organization">{{ __('Organization') }}</label>
                        <select name="organization_id" class="form-control">
                            <option value="">{{ __('Choose Organization') }}</option>
                            @foreach ($organizations as $org)
                                {{-- <option value="" selected disabled hidden>{{ __('Choose Organization') }}</option> --}}
                                <option value="{{ ($org->id) }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                {{--  <option value="{{ ($org->id) }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>  --}}
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
<div class="row">
        
                    <div class="col-md-6">
                            
                            @foreach ($donators as $donator)
                            
                            <div>
                                <div class="user-form-avatar">
                                    <img src="{{ !$donator->avatar==null ? asset('/uploads/avatars/'.$donator->avatar) : asset('/img/no-image.png') }}" alt="donator-logo" width="60">
                                </div>
                                <div class="user-form-info">
                                    <span class=""><strong>{{__('Name')}}: </strong>{{ $donator->name }}</span><br>
                                    <span class=""><strong>{{__('Email')}}: </strong>{{ $donator->email }}</span>
                                </div>
                                <div class="form-check user-form-check">
                                    <input type="radio" name="donator_id" value="{{ $donator->id }}"
                                    {{ old('donator_id') == $donator->id ? 'checked' : '' }}
                                    >
                                </div>
                                <hr width="60%" >
                            </div>
                            @endforeach
                            @if ($errors->has('donator_id'))
                            <div class="text-danger">
                                {{ $errors->first('donator_id') }}
                            </div>
                        @endif
                    </div>
    </div>
                    <label for="description">{{ __('Description') }}</label>
                    <div class="form-group">
                        {{-- <label for="description">{{ __('Description') }}</label> --}}
                        <textarea name="description" rows="5" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-danger">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>


                    {{-- narrative report --}}
                    <a data-toggle="collapse" data-target="#narrative-report" class="narrative-button">{{ __('Narrative Report') }} <i class="fas fa-angle-double-right"></i></a>
                    <div id="narrative-report" class="collapse col-md-12">
                        <div class="form-group text-center">
                            <label for="project_value"><span class="narrative-title"><i class="far fa-clipboard"></i>  {{ __('Narrative Report') }}</span></label>
                        </div>
                        <div class="form-group">
                            <label for="contract_number">{{ __('Contract Number') }}</label>
                            <input type="text" name="contract_number" class="form-control{{ $errors->has('contract_number') ? ' is-invalid' : '' }}" value="{{ old('contract_number') }}">
                            @if ($errors->has('contract_number'))
                                <div class="text-danger">
                                    {{ $errors->first('contract_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="project_value">{{ __('Project Value') }}</label>
                            <input type="text" name="project_value" class="form-control{{ $errors->has('project_value') ? ' is-invalid' : '' }}" value="{{ old('project_value') }}">
                            @if ($errors->has('project_value'))
                                <div class="text-danger">
                                    {{ $errors->first('project_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="application_area">{{ __('Application Area') }}</label>
                            <textarea rows="3" name="application_area" class="form-control{{ $errors->has('application_area') ? ' is-invalid' : '' }}" value="{{ old('application_area') }}"></textarea>
                            @if ($errors->has('application_area'))
                                <div class="text-danger">
                                    {{ $errors->first('application_area') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="authorized_person">{{ __('Authorized Person') }}</label>
                            <input type="text" name="authorized_person" class="form-control{{ $errors->has('application_area') ? ' is-invalid' : '' }}" value="{{ old('authorized_person') }}">
                            @if ($errors->has('authorized_person'))
                                <div class="text-danger">
                                    {{ $errors->first('authorized_person') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="coordinator">{{ __('Coordinator') }}</label>
                            <input type="text" name="coordinator" class="form-control{{ $errors->has('application_area') ? ' is-invalid' : '' }}" value="{{ old('coordinator') }}">
                            @if ($errors->has('coordinator'))
                                <div class="text-danger">
                                    {{ $errors->first('coordinator') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="short_description">{{ __('Short Description') }}</label>
                            <textarea name="short_description" rows="3" class="form-control{{ $errors->has('short_description') ? ' is-invalid' : '' }}" value="{{ old('short_description') }}"></textarea>
                            @if ($errors->has('short_description'))
                                <div class="text-danger">
                                    {{ $errors->first('short_description') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="accomplished_goals">{{ __('Accomplished Goals') }}</label>
                            <textarea name="accomplished_goals" rows="3" class="form-control{{ $errors->has('accomplished_goals') ? ' is-invalid' : '' }}" value="{{ old('accomplished_goals') }}"></textarea>
                            @if ($errors->has('accomplished_goals'))
                                <div class="text-danger">
                                    {{ $errors->first('accomplished_goals') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="goal_explanation">{{ __('Goal Explanation') }}</label>
                            <textarea name="goal_explanation" rows="3" class="form-control{{ $errors->has('goal_explanation') ? ' is-invalid' : '' }}" value="{{ old('goal_explanation') }}"></textarea>
                            @if ($errors->has('goal_explanation'))
                                <div class="text-danger">
                                    {{ $errors->first('goal_explanation') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="expected_results">{{ __('Expected Results') }}</label>
                            <textarea name="expected_results" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('expected_results') ? ' is-invalid' : '' }}" value="{{ old('expected_results') }}"></textarea>
                            @if ($errors->has('expected_results'))
                                <div class="text-danger">
                                    {{ $errors->first('expected_results') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="target_group_direct">{{ __('Direct Target Group') }}</label>
                            <textarea name="target_group_direct" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('target_group_direct') ? ' is-invalid' : '' }}" value="{{ old('target_group_direct') }}"></textarea>
                            @if ($errors->has('target_group_direct'))
                                <div class="text-danger">
                                    {{ $errors->first('target_group_direct') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="target_group_indirect">{{ __('Indirect Target Group') }}</label>
                            <textarea name="target_group_indirect" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('target_group_indirect') ? ' is-invalid' : '' }}" value="{{ old('target_group_direct') }}"></textarea>
                            @if ($errors->has('target_group_indirect'))
                                <div class="text-danger">
                                    {{ $errors->first('target_group_indirect') }}
                                </div>
                            @endif
                        </div>

                        {{-- new fields --}}

                    <div class="form-group">
                        <label for="difference_planned_involved">{{ __('If There Is Difference Between Planned And Involved, What Are The Reasons For This') }}</label>
                    <textarea name="difference_planned_involved" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('difference_planned_involved') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('difference_planned_involved'))
                            <div class="text-danger">
                                {{ $errors->first('difference_planned_involved') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="user_selection_method">{{ __('User Selection Method') }}</label>
                    <textarea name="user_selection_method" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('user_selection_method') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('user_selection_method'))
                            <div class="text-danger">
                                {{ $errors->first('user_selection_method') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="project_realisation_problems">{{ __('Project Realisation Problems') }}</label>
                        
                    <textarea name="project_realisation_problems" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('project_realisation_problems') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('project_realisation_problems'))
                            <div class="text-danger">
                                {{ $errors->first('project_realisation_problems') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="project_realisation_partners">{{ __('Project Realisation Partners') }}</label>
                        @if ( Config::get('app.locale') == 'sr')
                        <label for="" class="text-muted">
                            (Navedite sve partnere u realizaciji projekta: udruženja, ustanove i institucije, njihove tačne nazive,
                            aktivnosti u kojima ste sarađivali, da li je saradnja bila uspešna, da li je ostvareno formalno ili
                            neformalno partnerstvo, komentari itd.)
                        </label>
                        @endif
                    <textarea name="project_realisation_partners" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('project_realisation_partners') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('project_realisation_partners'))
                            <div class="text-danger">
                                {{ $errors->first('project_realisation_partners') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="project_promotion">{{ __('Project Promotion') }}</label>
                        @if ( Config::get('app.locale') == 'sr')
                        <label for="" class="text-muted">
                            (Navedite koji mediji su pratili realizaciju projekta i promotivni materijal koji ste koristili u cilju
                            promovisanja projekta (flajeri, posteri, internet prezentacije, i dr.)
                        </label>
                        @endif
                    <textarea name="project_promotion" rows="5"  class="narrative-editor" class="form-control{{ $errors->has('project_promotion') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('project_promotion'))
                            <div class="text-danger">
                                {{ $errors->first('project_promotion') }}
                            </div>
                        @endif
                    </div>

                        <div class="form-group">
                            <label for="other">{{ __('Other Remarks') }}</label>
                            <textarea name="other" rows="5"  class="form-control{{ $errors->has('other') ? ' is-invalid' : '' }}" value="{{ old('other') }}"></textarea>
                            @if ($errors->has('other'))
                                <div class="text-danger">
                                    {{ $errors->first('other') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="start_date">{{ __('Start Date') }} <i class="fas fa-calendar-alt"></i></label>
                            <div class="control">
                                <input class="date" name="start_date" type="date">
                            </div>
                        </div>
        
                        <div class="form-group">
                            <label for="start_date">{{ __('End Date') }} <i class="fas fa-calendar-alt"></i></label>
                            <div class="control">
                                <input class="date" name="end_date" type="date">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <a class="btn btn-danger" href="{{ route('admin.projects.index') }}"><i class="fas fa-times-circle"></i> {{ __('Cancel') }}</a>
                        <button type="submit" form="create-project-form" class="btn btn-success"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                        {{-- <a href="{{ route('admin.narrative.create') }}" class="pull-right"><button type="submit" form="create-narrative-form" class="btn btn-info"><i class="fas fa-file"></i> {{ __('Narrative') }}</button></a> --}}
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    var $editor = $('.narrative-editor')
    $editor.summernote({
      toolbar: [
        ['style', ['style']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['hr']],
        ['table', ['table']]
      ],
      height: 400
    })
  </script>

  
  <script>
  $(".narrative-button").click(function(){
        $(".fa-angle-double-right").toggleClass("arrow-rotate");
    }); 
  </script>
@endsection