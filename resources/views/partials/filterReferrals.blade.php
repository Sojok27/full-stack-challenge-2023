<details class="filter-btn" style="padding-bottom:45px;">
	<!-- <summary class="form-control col-md-6 btn btn-info">Click to show filters</summary> -->
	<summary class="btn btn-info">Show filters</summary>
	<form action="{{route('referrals-filtered')}}" method="get" class="containered" enctype="application/x-www-form-urlencoded">
		{{ csrf_field() }}
		@if($filter == true)
		<div style="margin-top: 5px;">
			<a class="btn btn-danger" style="float: right; margin-top:25px;" href="{{ url('referrals/') }}">Remove filters</a>
		</div>
		@endif
		<div class="form-group col-md-6">
			<label for="country">Countries</label>
			<select name="filter[country]" class="js-example-basic-single" id="country">
				<option value="">All</option>
				@foreach($places['names'] as $country)
				<option value="{{ $country }}" @if(isset($filters['country']) && $filters['country']==$country) selected @endif>{{ ucwords($country)  }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-4">
			<label for="city">Cities</label>
			<select name="filter[city]" class="js-example-basic-single" id="city">
			</select>
		</div>
		@foreach($filterBase as $name=>$column)
		@if($name != "country" && $name!= "city")
		<div class="form-group col-md-6">
			<label for="{{ $name }}">{{ ucwords(str_replace('_', ' ', $name)) }}</label>
			<select name="filter[{{ $name }}]" class="js-example-basic-single" id="{{ $name }}">
				<option value="">All</option>
				@foreach($column as $data)
				<option value="{{ $data }}" @if(isset($filters[$data]) && $filters[$data]==$country) selected @endif>{{ $data }}</option>
				@endforeach
			</select>
		</div>
		@endif
		@endforeach
		<div class="form-group col-md-6">
			<input type="submit" class="btn btn-primary" id="filter" value="Filter">
		</div>
	</form>
</details>
<script>
	places = JSON.parse(`{!!$placesJson!!}`);
	filters = JSON.parse(`{!!$filtersJson!!}`);
	$(document).ready(() => {
		$("#country").on("change", (e) => {
			setCities(e);
		});
		if($("#country").val() !=="") setCities($("#country")[0]);
	})
	const setCities = (e) => {
		let f = e?.target?.value || e.value;
		let html = "<option value=''>All</option>";
		let list = places['cities'][f];
		Object.keys(list).forEach((f) => {
			selected = undefined != filters["city"] && filters["city"] == list[f] ? "selected" : "";
			html += `<option value="${list[f]}" ${selected}>${list[f]}</option>`
		})
		$("#city").html(html);
	}
</script>