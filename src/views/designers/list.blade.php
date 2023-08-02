@extends('admin::inc/header')
@section('title', 'Lista Conturi')

@section('content')
<div class='details-list'><!--details-list-->
	<div class='details-left'>
		<h2>Listă Designeri</h2>
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
	
</div>

<div class="content-container">
	<div class='listing-element listing-header'>
		<div class='listing-box flex02 alignCenter'>
			<p>ID</p>
		</div>
		<div class='listing-box flex03'>
			<p>Nume</p>
		</div>
		<div class='listing-box flex03 alignCenter'>
			<p>Tip</p>
		</div>
		<div class='listing-box flex04 alignCenter'>
			<p>Email</p>
		</div>
		<div class='listing-box flex03 alignCenter'>
			<p>Telefon</p>
		</div>
		<div class='listing-box flex03 alignCenter'>
			<p>Data</p>
		</div>
		<div class='listing-box flex04 alignCenter'>
			<p>Status</p>
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
				<div class='listing-box flex03'>
					<p><a href='/admin/accounts/{{$item->id}}/edit'>{{ $item->name }} {{ $item->surname }}</a></p>
				</div>
				<div class='listing-box flex03 alignCenter'>
					<p>{{ $item->type }}</p>
				</div>
                <div class='listing-box flex04 alignCenter'>
					<p>{{ $item->email }}</p>
				</div>
				<div class='listing-box flex03 alignCenter'>
					<p>{{ $item->phone }}</p>
				</div>
				<div class='listing-box flex03 alignCenter'>
					<p>{{\Carbon\Carbon::parse($item->created_at)->format('Y-d-m')}}</p>
				</div>
                
				<div class='listing-box flex04 alignCenter'>
					<span class='general-btn noPointer status-{{$item->status}}'>{{$item->status_nice}}</span>
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
								<form action="/admin/accounts/{{ $item->id }}" method="POST">@method('DELETE') @csrf <input type="submit" value="Șterge"/></form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>

@endsection

