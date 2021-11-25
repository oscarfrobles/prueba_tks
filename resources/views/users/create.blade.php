@extends('layouts.app')

@section('content')   

<div class="container">
<form  method="POST" action="/users/store">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-6"><label class="required" for="name">Nombre</label></div>
        <div class="col-6"><input type="text" name="name"></div>
    </div>
    <div class="row">
            <div class="col-6"><label class="required" for="email">Email</label></div>
            <div class="col-6"><input type="text" name="email"></div>
    </div>
    <div class="row">
            <div class="col-6"><label class="required" for="password">Password</label></div>
            <div class="col-6"><input type="text" name="password"></div>
    </div>
    <div class="row">
            <div class="col-6"><label class="required" for="timezone">Timezone</label></div>
            <div class="col-6"><select class="form-control" name="timezone" id="timezone">
                    @foreach(Helpers::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                        <option value="{{ $timezone }}" {{ ( $timezone === old('timezone', $user->timezone)) ? 'selected' : '' }}>
                            {{ $timezone_gmt_diff }}
                        </option>
                    @endforeach
                </select></div>
    </div>
   <input type="submit">
</form>
@endsection
