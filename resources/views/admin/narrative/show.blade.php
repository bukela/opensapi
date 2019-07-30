@extends('layouts.admin')

@section('title')
<i class="fas fa-clipboard"></i> {{__('Narrative Report')}}
@endsection
@section('subtitle')
    {{__('View')}}
@endsection

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                    <table class="table table-bordered narrative-table">
                            <tbody>
                                <tr>
                                    <td colspan="2"></td>
                                  <th>{{ __('Contract Number') }}</th>
                                    <td>{{$narrative->contract_number}}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">{{ __('Organization') }}</th>
                                        <td colspan="2">{{$narrative->organization_name}}</td>
                                    </tr>
                                <tr>
                                  <th colspan="2">{{ __('Project Title') }}</th>
                                    <td colspan="2">{{$narrative->project_title}}</td>
                                </tr>
                                <tr>
                                <th colspan="2">{{ __('Project Value') }}</th>
                                    <td colspan="2">{{ number_format($narrative->project_value, 2) }}</td>
                                </tr>
                                <tr>
                                <th>{{ __('Project Funds') }}</th>
                                    <td>{{ number_format($narrative->project_funds, 2) }}</td>
                                {{-- </tr> --}}
                                {{-- <tr> --}}
                                <th>{{ __('Project Spent') }}</th>
                                    <td>{{ number_format($narrative->project_spent, 2) }}</td>
                                </tr>
                                <tr>
                                <th>{{ __('Start Date') }}</th>
                                    <td>{{ !$narrative->start_date == null ? date('d.M Y', strtotime($narrative->start_date)) : 'N/A' }}</td>
                                {{-- </tr>
                                <tr> --}}
                                <th>{{ __('End Date') }}</th>
                                    <td>{{ !$narrative->end_date == null ? date('d.M Y', strtotime($narrative->end_date)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                <th>{{ __('Application Area') }}</th>
                                    <td colspan="3">{{$narrative->application_area}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                <th>{{ __('Authorized Person') }}</th>
                                    <td>{{$narrative->authorized_person}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                <th>{{ __('Coordinator') }}</th>
                                    <td>{{$narrative->coordinator}}</td>
                                </tr>
                            </tbody>
                        </table>
                    
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Short Description') }}</div>
                        <div class="panel-body">{!! $narrative->short_description !!}</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Accomplished Goals') }}</div>
                        <div class="panel-body">{!! $narrative->accomplished_goals !!}</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Goal Explanation') }}</div>
                        <div class="panel-body">{{ $narrative->goal_explanation }}</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Expected Results') }}</div>
                        <div class="panel-body">{!! $narrative->expected_results !!}</div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="expected_results">{{ __('Expected Results') }}</label>
                        <div>{!! $narrative->expected_results !!}</div>
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="target_group_direct">{{ __('Direct Target Group') }}</label>
                        <div>{!! $narrative->target_group_direct !!}</div>
                    </div> --}}
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Direct Target Group') }}</div>
                        <div class="panel-body">{!! $narrative->target_group_direct !!}</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Indirect Target Group') }}</div>
                        <div class="panel-body">{!! $narrative->target_group_indirect !!}</div>
                    </div>
                    {{-- new fields --}}

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('If There Is Difference Between Planned And Involved, What Are The Reasons For This') }}</div>
                        <div class="panel-body">{!! $narrative->difference_planned_involved !!}</div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('User Selection Method') }}</div>
                        <div class="panel-body">{!! $narrative->user_selection_method !!}</div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Project Realisation Problems') }}</div>
                        <div class="panel-body">{!! $narrative->project_realisation_problems !!}</div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Project Realisation Partners') }}</div>
                        <div class="panel-body">{!! $narrative->project_realisation_partners !!}</div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Project Promotion') }}</div>
                        <div class="panel-body">{!! $narrative->project_promotion !!}</div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading narrative-heading">{{ __('Other Remarks') }}</div>
                        <div class="panel-body">{{ $narrative->other }}</div>
                    </div>
                    
                </div>
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
@endsection