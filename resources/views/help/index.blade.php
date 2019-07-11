@extends('layouts.same')

@section('content')

<section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">Help Center</h2>
        
            <nav class="float-left">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('help_index') }}">Help Center</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>  
            </nav>
        </div> <!-- container //  -->
        </section>

        <section class="section-content bg padding-y">
                <div class="container">
                
                <div class="row">
                    <main class="col-sm-9">
                
                <header class="section-heading">
                    <h2 class="title-section">Section name</h2>
                </header><!-- sect-heading -->
                
                    <article>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p>Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                
                    <a href="javascript: history.back()" class="btn btn-primary"> « Go back</a>
                
                    </article>
                    </main> <!-- col.// -->
                    <aside class="col-sm-3">
                        <article class="box">
                            <h6 class="title">Sidebar title</h6>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris
                            </p>
                        </article>
                    </aside> <!-- col.// -->
                </div>
                
                </div> <!-- container .//  -->
                </section>
@endsection