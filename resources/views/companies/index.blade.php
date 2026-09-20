@extends('leaute.app')
@section('content')
    <h2 class="text-center">Bu tashkilotlar ro'yxati</h2>
    <table class="table table-bordered">
            <thead>
                <tr>
                   <td>T/R</td>
                   <td>Tashkilot nomi</td>
                   <td>Tashkilot manzili</td>
                   <td>Tashkilot raqami</td>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $copmany)
                <tr>
                    <td>{{($companies->currentpage()-1)*$companies->perpage()+ $loop->index+1}}</td>
                    <td>{{$copmany->name}}</td>
                    <td>{{$copmany->address}}</td>
                    <td>{{$copmany->phone}}</td>
                </tr>
                @endforeach
            </tbody>
    </table>
    {{$companies->links()}}
@endsection