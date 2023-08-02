@extends('admin::inc/header')
@section('title', 'Lista Designeri')

@section('content')
<div class='details-list'><!--details-list-->
	<div class='details-left'>
		<h2>Listă Designeri</h2>
	</div>
	<div class='details-right'>
		<ul class='list-controls'>
			<li>
				<a href="" class='iconControl'>
					<span>
						<svg id="Download" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
							<path id="Download-2" data-name="Download" d="M12.9,9.755a.736.736,0,1,1,.991,1.088L10,14.386,6.107,10.843A.736.736,0,0,1,7.1,9.755l2.165,1.971V2.736a.736.736,0,0,1,1.472,0v8.99ZM3.455,14.363a.727.727,0,0,0-1.455,0v.97A2.667,2.667,0,0,0,4.667,18H15.333A2.667,2.667,0,0,0,18,15.333v-.97a.727.727,0,0,0-1.455,0v.97a1.212,1.212,0,0,1-1.212,1.212H4.667a1.212,1.212,0,0,1-1.212-1.212Z" transform="translate(-2 -2)" fill="#303D4D" fill-rule="evenodd"/>
						</svg>						  
					</span>
				</a>
			</li>
		</ul>
	</div>
</div><!--details-list-->
<div class='filter-tab'>
	<form method='POST' action='' class='filter-form'>
		<div class='filter-element flexed align-center-flex'>
			<p>Arată:</p>
			<div class='filter-hold'>
				<select name="items" id="items" value=''>
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>
		</div><!--filter-element-->
		<div class='filter-element'>
			<div class='filter-hold'>
				<select name="category" id="category" value=''>
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</div>
		</div><!--filter-element-->
		<div class='filter-element flexed align-center-flex'>
			<div class='filter-hold'>
				<select name="status" id="status" value=''>
					<option value="All">All</option>
					<option value="Published">Published</option>
					<option value="Hidden">Hidden</option>
				</select>
			</div>
		</div><!--filter-element-->
		
	</form>
	<div class='actions-tab'>
		<ul class='action-controls'>
			<li>
				<a href="/admin/designers/create" class='iconControl'>
					<span>
						<svg id="Plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
							<path id="Plus-2" data-name="Plus" d="M11,5A1,1,0,0,0,9,5V9H5a1,1,0,0,0,0,2H9v4a1,1,0,0,0,2,0V11h4a1,1,0,0,0,0-2H11Z" transform="translate(-4 -4)" fill="#ffffff" fill-rule="evenodd"/>
						  </svg>											
					</span>
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="content-container">
	<div class='listing-element listing-header'>
		<div class='listing-box flex02 alignCenter'>
			<p>ID</p>
		</div>
		<div class='listing-box flex04'>
			<p>Nume</p>
		</div>
		<div class='listing-box flex03 alignCenter'>
			<p>Email</p>
		</div>
		<div class='listing-box flex03 alignCenter'>
			<p>Data</p>
		</div>
		
		<div class='listing-box flex02 alignCenter'>
			<p>Actiuni</p>
		</div>
	</div>
	<div class='listing-elements-hold'>
		@foreach($items as $key => $item)
			<div class='listing-element {{ $loop->last ? 'lastElement' : '' }}'>
				<div class='listing-box flex02 alignCenter'>
					<p>{{$key+1}}</p>
				</div>
				<div class='listing-box flex04'>
					<p><a href='/admin/designers/{{$item->id}}/edit'>{{ $item->name }} {{ $item->surname }}</a></p>
				</div>
                <div class='listing-box flex03 alignCenter'>
					<p>{{ $item->email }}</p>
				</div>
				<div class='listing-box flex03 alignCenter'>
					<p>{{\Carbon\Carbon::parse($item->created_at)->format('Y-d-m')}}</p>
				</div>
                
				<div class='listing-box flex02 alignCenter'>
					<div class='more-actions-tab'>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 20">
							<g id="More" transform="translate(4) rotate(90)">
							<path id="More-2" data-name="More" d="M6.5,10.5a2,2,0,1,1-2-2A2,2,0,0,1,6.5,10.5Zm8,0a2,2,0,1,1-2-2A2,2,0,0,1,14.5,10.5Zm6,2a2,2,0,1,0-2-2A2,2,0,0,0,20.5,12.5Z" transform="translate(-2.5 -8.5)" fill="#8697a8" fill-rule="evenodd"/>
							</g>
						</svg>			  
						<ul class='more-list'>
							<li>
								<form action="/admin/designers/{{ $item->id }}" method="POST">@method('DELETE') @csrf <input type="submit" value="Șterge"/></form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>

@endsection

