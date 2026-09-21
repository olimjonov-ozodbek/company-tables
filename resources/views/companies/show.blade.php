@extends('leaute.app')
@section('content')
<h2 class="text-center p-3">Tahkilot haqida ma'lumot</h2>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 40%;">Tashkilot nomi</th>
                        <td>{{$company->name}}</td>
                    </tr>
                    <tr>
                        <th>Tashkilot manzili</th>
                        <td>{{$company->address}}</td>
                    </tr>
                    <tr>
                        <th>Tashkilot telefon raqami</th>
                        <td>{{$company->phone}}</td>
                    </tr>
                    <tr>
                        <th>Qo'shilgan vaqti</th>
                        <td>{{$company->created_at}}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Ortga qaytish</a>
            </div>
        </div>
    </div>
</div>
<br>
@endsection