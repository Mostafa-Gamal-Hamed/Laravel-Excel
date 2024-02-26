@extends('test::layouts.master')

@section('content')
    <div class="container">
        <h1 class="mt-5 text-center">Check File</h1>
        <div class="mt-5">
            <form action="{{url('import')}}" method="post">
                @csrf
                @foreach ($firstRow as $row)
                    <div class="d-flex">
                        <h3 class="col-4">{{$row}}</h3>
                        <select name="validate[{{$row}}]" class="form-select" aria-label="Default select example">
                            <option value="required">required</option>
                            <option value="string">text</option>
                            <option value="numeric">numbers</option>
                        </select>
                    </div>
                    <br>
                @endforeach

                <button type="submit" class="btn btn-success w-25">Import</button>
            </form>
        </div>
    </div>
@endsection
