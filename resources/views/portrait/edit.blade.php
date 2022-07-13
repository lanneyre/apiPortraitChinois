@extends("portrait.index")

@section("aside")
<h3>{{$portrait->nom}}</h3>

<form action="{{route('portrait.update', $portrait)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" placeholder="nom" class="form-control" value="{{$portrait->nom}}">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{$portrait->description}}</textarea>
    </div>
    <div class="form-group">
        <br>
        <figure>
            <img src='@if(!empty($portrait->image)) {{$portrait->image}} @else {{"/storage/img/noImage.jpg"}} @endif ' alt="{{$portrait->nom}}" class="miniatureShow" >
        </figure>
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
        <div class="col d-flex"><input type="submit" value="Edit" class="btn btn-primary"></div>
    </div>
</form>
@endsection
