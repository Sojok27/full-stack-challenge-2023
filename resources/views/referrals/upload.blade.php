@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bulk Upload Referral</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('errors')
                    <div class="alert alert-info">
                        <strong>Note - </strong> Please ensure that the data is in csv file and the column sequence is as mentioned below: <br />
                        <hr />
                        <h4>country, reference_no, organisation, province, district, city, street_address, gps_location, facility_name, facility_type, provider_name, position, phone, email, website, pills_available, code_to_use, type_of_service, note, womens_evaluation</h4>
                        <hr />
                    </div>
                    <form method="POST" action="/referrals/upload" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="reference_no" >Referral File : </label>
                            <input type="file" id="referral_file" name="referral_file" class="form-control" placeholder="Click to upload"/>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
