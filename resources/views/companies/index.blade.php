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
                   <th>T/R</th>
                   <th>Tashkilot nomi</th>
                   <th>Tashkilot manzili</th>
                   <th>Tashkilot raqami</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                <tr>
                    <td>{{($companies->currentpage()-1)*$companies->perpage()+ $loop->index+1}}</td>
                    <td> <a href="{{route('companies.show',['company'=>$company->id])}}">{{$company->name}}</a></td>
                    <td>{{$company->address}}</td>
                    <td>{{$company->phone}}</td>
                </tr>
                @endforeach
            </tbody>
    </table>
    {{$companies->links()}}
@endsection