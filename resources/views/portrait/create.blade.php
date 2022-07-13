@extends("portrait.index")

@section("aside")
<h2>Creation d'un portrait</h2>
@if(!empty(session('error'))) {{session('error')}} @endif
<form action="{{route('portrait.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" placeholder="nom" class="form-control">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="imageOrdi">Image depuis l'ordinateur</label>
        <input type="file" name="imageOrdi" id="imageOrdi" placeholder="image" class="form-control">
    </div>
    <div class="form-group">
        <label for="imageUrl">Url Image</label>
        <input type="text" name="imageUrl" id="imageUrl" placeholder="image" class="form-control">
    </div>
    <div class="row mt-2 mb-2">
        <div class="col d-flex"><input type="reset" value="Reset" class="btn btn-secondary"></div>
        <div class="col d-flex"><input type="submit" value="Create" class="btn btn-primary"></div>
    </div>
</form>
@endsection