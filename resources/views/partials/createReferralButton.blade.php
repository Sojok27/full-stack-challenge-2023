<!-- <a href="/referrals/create" class="btn btn-success pull-right col-md-offset-1">Add New Referral</a> -->
@if (Auth::user()->hasAnyRole(["admin", "supervisor"]))
<a href="/referrals/upload" class="btn btn-success pull-right">Bulk Upload</a>
@endif