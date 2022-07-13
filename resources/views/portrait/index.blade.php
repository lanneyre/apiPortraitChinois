@extends("layout.template")

@section("listing")
    <h1>Listing des portraits chinois <a href="{{route("portrait.create")}}" class="btn btn-link"><i class="fa-solid fa-plus"></i></a></h1>
    @include("layout.message")
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>description</th>
                <th>image</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($portraits as $portrait)
            <tr>
                <td>{{$portrait->id}}</td>
                <td>{{$portrait->nom}}</td>
                <td>{{$portrait->description}}</td>
                <td>@if(!empty($portrait->image)) <img src="{{$portrait->image}}" alt="{{$portrait->nom}}" class="miniature" > @else <img src="/storage/img/noImage.jpg" alt="{{$portrait->nom}}" class="miniature" > @endif</td>
                <td><a href="{{route("portrait.show", $portrait)}}" class="btn btn-link"><i class="fa-solid fa-eye"></i></a></td>
                <td><a href="{{route("portrait.edit", $portrait)}}" class="btn btn-link"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td>
                    <form action="{{route("portrait.destroy", $portrait)}}" method="post">
                        @csrf
                        @method("delete")
                        <button type="submit" class="btn btn-link"><i class="fa-solid fa-trash-can"></i></button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection


@section("aside")
Un portrait chinois est un jeu littéraire de type questionnaire de Proust où il s'agit de déceler certains aspects de la personnalité d'un individu ou d'identifier ses goûts ou ses préférences personnelles.
Vous allez donc devoir créer une API, à l’aide d’un framework, permettant de gérer une bdd sur ce thème et permettant ce qui suit :
@endsection
