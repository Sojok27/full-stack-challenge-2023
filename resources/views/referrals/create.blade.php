@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Referral</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('errors')
                    <form method="POST" action="/referrals">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="reference_no" >Reference No : </label>
                            <input type="text" id="reference_no" name="reference_no" class="form-control" placeholder="Reference No"/>
                        </div>

                        <div class="form-group">
                            <label for="organisation" >Organisation : </label>
                            <input type="text" id="organisation" name="organisation" class="form-control" placeholder="Organisation"/>
                        </div>

                        <div class="form-group">
                            <label for="province" >Province : </label>
                            <input type="text" id="province" name="province" class="form-control" placeholder="Province"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="district" >District : </label>
                            <input type="text" id="district" name="district" class="form-control" placeholder="District"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="city" >City : </label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="City"/>
                        </div>

                        <div class="form-group">
                            <label for="street_addr" >Address : </label>
                            <textarea id="street_addr" name="street_addr" class="form-control" placeholder="Address..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="zipcode" >Zipcode : </label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zipcode"/>
                        </div>

                        <div class="form-group">
                            <label for="country" >Country : </label>
                            <input type="text" id="country" name="country" class="form-control" placeholder="Country"/>
                        </div>

                        <div class="form-group">
                            <label for="provider_name" >Provider Name : </label>
                            <input type="text" id="provider_name" name="provider_name" class="form-control" placeholder="Provider Name"/>
                        </div>

                        <div class="form-group">
                            <label for="phone" >Phone : </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone"/>
                        </div>

                        <div class="form-group">
                            <label for="facility_type" >Facility Type: </label>
                            <input type="text" id="facility_type" name="facility_type" class="form-control" placeholder="Facility Type"/>
                        </div>

                        <div class="form-group">
                            <label for="position" >Position : </label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="Position"/>
                        </div>

                        <div class="form-group">
                            <label for="gps_location" >GPS Location : </label>
                            <input type="text" id="gps_location" name="gps_location" class="form-control" placeholder="Longitude, Latitude"/>
                        </div>

                        <div class="form-group">
                            <label for="email" >Email : </label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email"/>
                        </div>

                        <div class="form-group">
                            <label for="website" >Website : </label>
                            <input type="text" id="website" name="website" class="form-control" placeholder="Website"/>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
