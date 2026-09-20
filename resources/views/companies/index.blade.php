@extends('leaute.app')
@section('content')
    <h2 class="text-center p-3">Bu tashkilotlar ro'yxati</h2>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{'companies/create'}}"><button class="btn btn-success" type="button">Tahkilot qo'shish</button></a>
  
</div>
<br>
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