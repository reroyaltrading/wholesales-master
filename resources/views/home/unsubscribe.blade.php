@extends('layouts.same')

@section('content')

<section class="section-content bg padding-y border-top">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <section class="section-name bg padding-y  text-center">
                        <div class="container">
                        <h4>{{ $removed ? 'Email sucessfully removed' : 'Looks like you e-mail was removed already' }}</h4>
                        <p>{{ $removed ? $subs->email : 'Email not found' }}</p>
                        </div><!-- container // -->
                </section>
            </div>
        </div>
    </div>
</section>
@endsection