@extends('layouts.admin') 
@section('title')
<i class="fas fa-forward"></i> {{__('Financial Report')}}
@endsection
 
@section('content')

<div class="block block-rounded block-bordered">
    <div class="block-header table-project-info">
        <div class="block-options-simple pull-left">
            {{__('Organization Name')}}: {{ $project->organization->name }} <br>
        
            {{__('Project Name')}}: {{ $project->title }}
        </div>
        @if(!empty($project->narrative))
        <div class="pull-right">
            {{ __('Narrative Report') }} 
            <a href="{{ route('admin.narrative.edit',$project->narrative->id) }}"  title="{{__('edit narrative')}}"><button type="button" form="edit-narrative-form" class="btn btn-default"><i class="fas fa-file"></i></button></a>
            <a href="{{ route('admin.narrative.show',$project->narrative->id) }}" title="{{__('view narrative')}}"><button type="button" class="btn btn-default"><i class="fas fa-eye" ></i></button></a>
        </div>
        @endif
    </div>
    <div class="block-table">
        <table class="table table-fixed">
        <thead><th colspan="5"></th><th colspan="4" class="text-center">{{ __('Personal Funds') }}</th><th colspan="4" class="text-center">{{ __('Donator Funds') }}</th></thead>
            <thead class="report-head">
                <th>{{__('Item')}}</th>
                <th>{{__('Payment Date')}}</th>
                <th>{{__('Invoice Number')}}</th>
                <th>{{__('Total Approved')}}</th>

                <th>{{__('Planned')}}</th>
                <th>{{__('Spent')}}</th>
                <th>{{__('Remaining Amount')}}</th>
                <th>{{__('Total Spent')}} %</th>

                <th>{{__('Planned')}}</th>
                <th>{{__('Spent')}}</th>
                <th>{{__('Remaining Amount')}}</th>
                <th>{{__('Total Spent')}} %</th>
                <th class="text-center">
                <a href="{{ route('admin.costs.create', $project->id)  }}" title="add cost"><button class="btn btn-primary" type="button"><i class="glyphicon glyphicon-plus"></i> {{__('Cost')}}</button></a></th>
                </tr>
            </thead>
            <tbody>
                <thead class="summary-head"><tr><th colspan="13">{{ __('Direct Costs') }}</th></tr></thead>
                @foreach ($project->categories as $pro)
                {{-- {{ dd($pro) }} --}}
                {{-- {{ dd($pro->costs) }} --}}
                @if($pro->direct_cost == 1)
                    <tr class="costs-categories">
                        <td colspan="13">{{ $pro->name }}</td>
                        
                    </tr>
                    @foreach($pro->costs as $prc)
                    @if($prc->status == 'pending')
                    <tr bgcolor="#f4bf42">
                    @elseif($prc->status == 'rejected')
                    <tr bgcolor="#f45f42">
                    @else    
                    <tr>
                    @endif
                        <td>{!! $prc->description !!}</td>
                        <td>{{ !empty($prc->payment_date) ? date("d-m-Y", strtotime($prc->payment_date)) : '' }}</td>
                        <td>{{ $prc->invoice_number }}</td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="spent-2">{{ number_format($prc->spent_private, 2) }}</td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right">{{ number_format($prc->spent_donator, 2) }}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center cost-edit">
                            @if(isset($prc->image->filename))
                            <a href="{{ asset('/uploads/documents/'.$prc->image->filename)}}" title="{{__('Download Report')}}" download><i class="fas fa-download"></i></a>&nbsp;
                            @else
                            <a class="fas fa-download disabled" title="{{__('Report Missing')}}"></a>&nbsp; @endif
                        <a href="{{ route('admin.cost.edit', $prc->id) }}" title="{{ __('Edit Cost') }}"><i class="fas fa-edit"></i> </a>&nbsp;
                            <a class="delete__confirm" href="{{ route('admin.cost.destroy', $prc->id) }}" title="{{ __('Delete Cost') }}"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    
{{-- {{ dd($pro) }} --}}
                    <tr class="costs-sum">
                        <td>Total&nbsp;:&nbsp;{{ $pro->name }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($pro->approved_for_category + $pro->approved_for_category_private, 2) }}</td>
                        <td class="approved-1">{{ number_format($pro->approved_for_category_private, 2) }}</td>
                        <td>{{ number_format($pro->costs->sum('spent_private'), 2) }}</td>
                        <td>
                            {{ number_format($pro->approved_for_category_private - $pro->costs->sum('spent_private'),
                            2)}}
                        </td>
                        <td>{{ !empty($pro->total_categories) && $pro->total_categories != 0 ? round($pro->costs->sum('spent_private')
                            * 100 / $pro->total_categories, 2) : '' }} %</td>
{{-- donator fields --}}
                        <td class="approved-1">{{ number_format($pro->approved_for_category, 2) }}</td>
                        <td>{{ number_format($pro->costs->sum('spent_donator'), 2) }}</td>
                        <td>
                            {{ number_format($pro->approved_for_category - $pro->costs->sum('spent_donator'),
                            2)}}
                        </td>
                        <td>{{ !empty($pro->approved_for_category) && $pro->approved_for_category != 0 ? round($pro->costs->sum('spent_donator')
                            * 100 / $pro->approved_for_category, 2) : '' }} %</td>
                    </tr>
                    @endif
                    @endforeach
                    <thead class="summary-head"><tr><th colspan="13">{{ __('Indirect Costs') }}</th></tr></thead>

                    @foreach ($project->categories as $pro)
                {{-- {{ dd($pro) }} --}}
                {{-- {{ dd($pro->costs) }} --}}
                @if($pro->direct_cost == 0)
                    <tr class="costs-categories">
                        <td colspan="13">{{ $pro->name }}</td>
                        
                    </tr>
                    @foreach($pro->costs as $prc)
                    @if($prc->status == 'pending')
                    <tr bgcolor="#f4bf42">
                    @elseif($prc->status == 'rejected')
                    <tr bgcolor="#f45f42">
                    @else    
                    <tr>
                    @endif
                        <td>{!! $prc->description !!}</td>
                        <td>{{ !empty($prc->payment_date) ? date("d-m-Y", strtotime($prc->payment_date)) : '' }}</td>
                        <td>{{ $prc->invoice_number }}</td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="spent-2">{{ number_format($prc->spent_private, 2) }}</td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right"></td>
                        <td class="table-align-right">{{ number_format($prc->spent_donator, 2) }}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center cost-edit">
                            @if(isset($prc->image->filename))
                            <a href="{{ asset('/uploads/documents/'.$prc->image->filename)}}" title="{{__('Download Report')}}" download><i class="fas fa-download"></i></a>&nbsp;
                            @else
                            <a class="fas fa-download disabled" title="{{__('Report Missing')}}"></a>&nbsp; @endif
                            <a href="{{ route('admin.cost.edit', $prc->id) }}" title="{{ __('Edit Cost') }}"><i class="fas fa-edit"></i> </a>&nbsp;
                            <a class="delete__confirm" href="{{ route('admin.cost.destroy', $prc->id) }}" title="{{ __('Delete Cost') }}"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    
{{-- {{ dd($pro) }} --}}
                    <tr class="costs-sum">
                        <td>Total&nbsp;:&nbsp;{{ $pro->name }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($pro->approved_for_category + $pro->approved_for_category_private, 2) }}</td>
                        <td class="approved-1">{{ number_format($pro->approved_for_category_private, 2) }}</td>
                        <td>{{ number_format($pro->costs->sum('spent_private'), 2) }}</td>
                        <td>
                            {{ number_format($pro->approved_for_category_private - $pro->costs->sum('spent_private'),
                            2)}}
                        </td>
                        <td>{{ !empty($pro->total_categories) && $pro->total_categories != 0 ? round($pro->costs->sum('spent_private')
                                * 100 / $pro->total_categories, 2) : '' }} %</td>
                        <td class="approved-1">{{ number_format($pro->approved_for_category, 2) }}</td>
                        <td>{{ number_format($pro->costs->sum('spent_donator'), 2) }}</td>
                        <td>
                            {{ number_format($pro->approved_for_category - $pro->costs->sum('spent_donator'),
                            2)}}
                        </td>
                        <td>{{ !empty($pro->approved_for_category) && $pro->approved_for_category != 0 ? round($pro->costs->sum('spent_donator')
                            * 100 / $pro->approved_for_category, 2) : '' }} %</td>
                    </tr>
                    @endif
                    @endforeach
                    <thead class="summary-by-type">
                        <th colspan="4">{{__('Summary')}}</th>
                        <th>{{__('Total private planned')}}</th>
                        <th>{{__('Total private spent')}}</th>
                        <th>{{__('Total private remain')}}</th>
                        <th>{{__('Total private spent %')}}</th>

                        <th>{{__('Total donator planned')}}</th>
                        <th>{{__('Total donator spent')}}</th>
                        <th>{{__('Total donator remain')}}</th>
                        <th>{{__('Total donator spent %')}}</th>
                       
                        <th></th>

                       
                    </thead>

                    @php
                        $total_approved_private = $project->categories->pluck('approved_for_category_private')->sum();
                        $total_spent_private = $project->costs->pluck('spent_private')->sum();
                        $total_remain_private = $total_approved_private - $total_spent_private;

                        $total_approved_donator = $project->categories->pluck('approved_for_category')->sum();
                        $total_spent_donator = $project->costs->pluck('spent_donator')->sum();
                        $total_remain_donator = $total_approved_donator - $total_spent_donator;
                    @endphp

                    <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ number_format($total_approved_private, 2) }}</th>
                            <th>{{ number_format($total_spent_private, 2) }}</th>
                            <th>{{ number_format( $total_remain_private, 2) }}</th>
                            {{-- {{dd($total_remain_private)}} --}}
                            <th>{{ isset($total_remain_private) && !empty($total_remain_private) ? round(100 - $total_remain_private * 100 / $total_approved_private,
                                2) : '' }} %</th>
                            
                            <th>{{ number_format($total_approved_donator, 2) }}</th>
                            <th>{{ number_format($total_spent_donator, 2) }}</th>
                            <th>{{ number_format( $total_remain_donator, 2) }}</th>
                            <th>{{ isset($total_remain_donator) && !empty($total_remain_donator) ? round(100 - $total_remain_donator * 100 / $total_approved_donator,
                                2) : '' }} %</th>
                            
                    </tr>

                    <thead class="summary-head">
                        <th colspan="2">{{__('Total Costs')}}</th>
                        <th colspan="2">{{__('Total Approved Funds')}}</th>
                        <th colspan="2">{{__('Total Spent Funds')}}</th>
                        <th colspan="2">{{__('Total Remaining Funds')}}</th>
                        <th colspan="3">{{__('Total Spent Funds Percent')}}</th>
                        <th></th>
                        <th></th>

                       
                    </thead>
                    <tr>
                            <th></th>
                            <th></th>
                            <th colspan="2">{{ number_format($project->approved_funds, 2) }}</th>
                            <th colspan="2">{{ number_format($project->spent_funds, 2) }}</th>
                            <th colspan="2">{{ number_format($project->remaining_funds, 2) }}</th>
                            <th colspan="2">{{ $project->approved_funds !== null ? round(100 - $project->remaining_funds * 100 / $project->approved_funds,
                                2) : '' }} %</th>
                            <th></th>
                    </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
 
@section('script')
@if ( Config::get('app.locale') == 'en')
<script>
    $('.delete__confirm').on('click', function (e) {
        e.preventDefault();

        // var form = $(this).data('form-id');
        var link = this;

        swal({
            title: "Are you sure?",
            text: "Cost will be deleted.",
            icon: "warning",
            buttons: [true, 'Delete']
        }).then(function(value) {
            if (value) window.location = link.href;
        });
    })
</script>
@endif

@if ( Config::get('app.locale') == 'sr')
<script>
    $('.delete__confirm').on('click', function (e) {
        e.preventDefault();

        // var form = $(this).data('form-id');
        var link = this;

        swal({
            title: "Da li ste sigurni?",
            text: "Trošak ce biti obrisan.",
            icon: "warning",
            buttons: [true, 'Delete']
        }).then(function(value) {
            if (value) window.location = link.href;
        });
    })
</script>
@endif

@endsection