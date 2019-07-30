@extends('layouts.admin')

@section('content')
<div class="table-responsive">
    <table class="table">
        <tr class="table__header">
            <th>
                Direktni Troskovi
            </th>
        </tr>
        <tr class="table__subheader">
            <th>
                Direktni Troskovi
            </th>
        </tr>
        <tr class="table__single">
           <td>something</td>
           <td>something</td>
           <td>something</td>
           <td>something</td>
           <td>something</td>
           <td>something</td>
        </tr>
        <tr class="table-bottom__single">
            <td style="width: 80%">something</td>
            <td style="width: 20%">something</td>
        </tr>
    </table>
</div>
    {{--<div class="container">--}}
        {{--<table class="table-header col-md-12">--}}
            {{--<tr class="header-purple">--}}
                {{--<td colspan="3" class="col-md-6 capitalize">naziv udruzenja:</td>--}}
                {{--<td colspan="3" class="col-md-6">{{ $project->user->name }}</td>--}}
            {{--</tr>--}}
            {{--<tr class="header-blue">--}}
                {{--<td colspan="3" class=" col-md-6 capitalize">Naziv Projekta:</td>--}}
                {{--<td colspan="3" class="col-md-6">{{ $project->title }}</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td colspan="6">--}}
                    {{--<div class="table-space"></div>--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--</table>--}}

         {{--{{dd($project->costs)}}--}}

        {{--<table class="sum-table">--}}
            {{--<tr class="table-blue">--}}
                {{--<td class="col-md-1">--}}
                    {{--Br. budzetske stavke--}}
                {{--</td>--}}
                {{--<td class="col-md-3">--}}
                    {{--stavka--}}
                {{--</td>--}}
                {{--<td class="col-md-1">--}}
                    {{--Ukupno odobrena sredstva, u dinarima--}}
                {{--</td>--}}
                {{--<td class="col-md-1">--}}
                    {{--Ukupno utrosena sredstva, u dinarima--}}
                {{--</td>--}}
                {{--<td class="col-md-1">--}}
                    {{--Preostali iznos u dinarima--}}
                {{--</td>--}}
                {{--<td class="col-md-1">--}}
                    {{--Ukupno utroseno u %--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<th colspan="6" class="capitalize">1.direktni troskovi projekta--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>--}}
                    {{--1.1.--}}
                {{--</td>--}}
                {{--<td colspan="5">--}}
                    {{--Honorarni clanovi projektnog tima--}}
                {{--</td>--}}
            {{--</tr>--}}

            {{--@foreach ($project->costs as $pro)--}}
                {{--@if ($pro->category_id == 1)--}}
                    {{--<tr class="table-white">--}}
                        {{--<td>1.1.{{ $loop->count }}.</td>--}}
                        {{--<td>{!! $pro->description !!}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->spent }}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->category_id }}</td>--}}
                        {{--<td class="table-align-right"></td>--}}
                        {{--<td class="table-align-right"></td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
            {{--@endforeach--}}

            {{--<tr class="table-orange">--}}
                {{--<td colspan="6">--}}
                    {{--NAPOMENA:Dodatne kolone unositi iznad ove kolone.--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<td colspan="2" class="table-align-right">UKUPNO honorarni</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>--}}
                    {{--1.2.--}}
                {{--</td>--}}
                {{--<td colspan="5">--}}
                    {{--Troskovi prevoza--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--@foreach ($project->costs as $pro)--}}
                {{--@if ($pro->category_id == 2)--}}
                    {{--<tr class="table-white">--}}
                        {{--<td>1.2.{{ $loop->count }}.</td>--}}
                        {{--<td>{!! $pro->description !!}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->spent }}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->category_id }}</td>--}}
                        {{--<td class="table-align-right"></td>--}}
                        {{--<td class="table-align-right"></td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
            {{--@endforeach--}}
             {{--<tr class="table-white">--}}
                {{--<td>1.2.2.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.2.3.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.2.4.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-orange">--}}
                {{--<td colspan="6">--}}
                    {{--NAPOMENA:Dodatne kolone unositi iznad ove kolone.--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<td colspan="2" class="table-align-right">UKUPNO prevoz</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>--}}
                    {{--1.3.--}}
                {{--</td>--}}
                {{--<td colspan="5">--}}
                    {{--Troskovi materijala za aktivnosti--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--@foreach ($project->costs as $pro)--}}

                {{--@if ($pro->category_id == 4)--}}
                    {{--<tr class="table-white">--}}
                        {{--<td>1.3.</td>--}}
                        {{--<td>{!! $pro->description !!}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->spent }}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->category_id }}</td>--}}
                        {{--<td class="table-align-right"></td>--}}
                        {{--<td class="table-align-right"></td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
            {{--@endforeach--}}
             {{--<tr class="table-white">--}}
                {{--<td>1.3.2.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.3.3.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.3.4.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-orange">--}}
                {{--<td colspan="6">--}}
                    {{--NAPOMENA:Dodatne kolone unositi iznad ove kolone.--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<td colspan="2" class="table-align-right">UKUPNO matrijal</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>--}}
                    {{--1.4.--}}
                {{--</td>--}}
                {{--<td colspan="5">--}}
                    {{--Ostali troskovi--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.4.1.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.4.2.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.4.3.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>1.4.4.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-orange">--}}
                {{--<td colspan="6">--}}
                    {{--NAPOMENA:Dodatne kolone unositi iznad ove kolone.--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<td colspan="2" class="table-align-right">UKUPNO ostali troskovi</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-blue">--}}
                {{--<td colspan="2" class="table-align-right">--}}
                    {{--UKUPNO DIREKTNI TROSKOVI--}}
                {{--</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td colspan="6">--}}
                    {{--<div class="table-space"></div>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-purple">--}}
                {{--<th colspan="6" class="capitalize">2.INDIREKTNI TROSKOVI--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>--}}
                    {{--2.1.--}}
                {{--</td>--}}
                {{--<td colspan="5">--}}
                    {{--Administrativni troskovi--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--@foreach ($project->costs as $pro)--}}
                {{--@if ($pro->category_id == 3)--}}
                    {{--<tr class="table-white">--}}
                        {{--<td>2.1.{{ $loop->count }}.</td>--}}
                        {{--<td>{!! $pro->description !!}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->spent }}</td>--}}
                        {{--<td class="table-align-right">{{ $pro->category_id }}</td>--}}
                        {{--<td class="table-align-right"></td>--}}
                        {{--<td class="table-align-right"></td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
            {{--@endforeach--}}
             {{--<tr class="table-white">--}}
                {{--<td>2.1.2.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>2.1.3.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-white">--}}
                {{--<td>2.1.4.</td>--}}
                {{--<td></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-orange">--}}
                {{--<td colspan="6">--}}
                    {{--NAPOMENA:Dodatne kolone unositi iznad ove kolone.--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr class="table-blue">--}}
                {{--<td colspan="2" class="table-align-right capitalize">UKUPNO INDIREKTNI TROSKOVI</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
            {{--<tr class="table-dark">--}}
                {{--<td colspan="2" class="table-align-right">--}}
                    {{--DIREKTNI + INDIREKTNI TROSKOVI--}}
                {{--</td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
                {{--<td class="table-align-right"></td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    {{--</div>--}}




@endsection
