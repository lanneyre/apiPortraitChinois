@extends("portrait.index")

@section("aside")
    <h2>{{$portrait->nom}}</h2>
    <figure>
        <img src='@if(!empty($portrait->image)) {{$portrait->image}} @else {{"/storage/img/noImage.jpg"}} @endif ' alt="{{$portrait->nom}}" class="miniatureShow" >
        <figcaption>
            {{$portrait->description}}
        </figcaption>
    </figure>
    
    <h3>
        Questions
    </h3>
    <ul>
        @foreach($portrait->questions as $question)
        <li>{{$question->nom}}</li>
        @endforeach
    </ul>

    <h3>
        Resultats posiibles
    </h3>
    <ul>
        @foreach($portrait->resultats as $resultat)
        <li>{{$resultat->nom}}</li>
        @endforeach
    </ul>
    <!-- {{$portrait->questions}} -->
@endsection