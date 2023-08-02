@extends('admin::inc/header')
@section('title', 'Adaugă cont')
@include('admin::inc/generalErrors')

@section('content')
<div class='details-bar'><!--details-bar-->
	<div class='details-left'>
		<h2>Adaugă cont</h2>
	</div>
	<div class='details-center'>
		<ul class='details-nav nav-tabs'>
			<li class='detail-selected'>
				<a href="" data-target="detalii">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13.1 16">
						<path id="Text-2" data-name="Text" d="M5.2,2H11a.75.75,0,0,1,.53.22l4.35,4.35a.75.75,0,0,1,.22.53v8.7A2.222,2.222,0,0,1,13.9,18H5.2A2.222,2.222,0,0,1,3,15.8V4.2A2.222,2.222,0,0,1,5.2,2Zm0,1.5a.721.721,0,0,0-.7.7V15.8a.721.721,0,0,0,.7.7h8.7a.721.721,0,0,0,.7-.7V7.85H11a.75.75,0,0,1-.75-.75V3.5Zm6.55,1.061L13.539,6.35H11.75ZM5.9,7.825a.75.75,0,0,1,.75-.75H8.1a.75.75,0,0,1,0,1.5H6.65A.75.75,0,0,1,5.9,7.825Zm.75,2.15a.75.75,0,1,0,0,1.5h5.8a.75.75,0,1,0,0-1.5Zm0,2.9a.75.75,0,0,0,0,1.5h5.8a.75.75,0,0,0,0-1.5Z" transform="translate(-3 -2)" fill="#6C7A87" fill-rule="evenodd"/>
					</svg> 
					Detalii
				</a>
			</li>
		</ul>	
	</div>
	<div class='details-right'>
		<a class='general-btn backBtn' href="/admin/accounts">Înapoi</a>	
	</div>
</div><!--details-bar-->

<div class="content-container">
    <div class="cms-body">
	<form method="POST" action='/admin/accounts/'>
		@csrf
		
		<div class='flex-inputs flex100'>
			<div class="input-element">
				<label for="name">Nume</label>
				<input class='builNiceUrl' data-composite='true' data-target='url' type="text" name="name" id='name' value="">
			</div>
            <div class="input-element">
				<label for="surname">Prenume</label>
				<input data-compositeField='true' type="text" name="surname" id='surname' value="">
			</div>
            <div class="input-element">
				<label for="email">Email</label>
				<input type="text" name="email" id='email' value="">
			</div>
            <div class="input-element">
				<label for="phone">Telefon</label>
				<input type="text" name="phone" id='phone' value="">
			</div>
			<div class="input-element">
				<label for="url">Url</label>
				<input type="text" name="url" id='url' value="">
			</div>
      <div class="input-element">
				<label for="type">Tip</label>
				<select name='type' id='type' value="">
          <option value="">Alege tip</option>
					<option value="designer">Designer</option>
					<option value="client">Client</option>
				</select>
			</div>
			<div class="input-element textarea">
				<label for="description">Descriere</label>
				<textarea name="description" id="description" value=''></textarea>
			</div>
			<div class="input-element">
				<label for="status">Status</label>
				<select name='status' id='status' value="">
          <option value="">Alege status</option>
					<option value="published">Publicat</option>
					<option value="hidden">Ascuns</option>
					<option value="pending">În așteptare</option>
				</select>
			</div>
			
		</div>
		<input class="general-btn" type="submit" value="Adaugă">
	</form>
	</div>
</div>


@endsection
