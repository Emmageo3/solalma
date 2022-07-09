<?php

use App\Models\Section;

$sections = Section::sections();

?>
<div id="header">
	<div class="container">
		<div id="welcomeLine" class="row">
			<div class="span6">Bienvenue!<strong> Emma</strong></div>
			<div class="span6">
				<div class="pull-right">
					<a href="{{ url('/cart') }}">
                        <span class="btn btn-mini btn-primary">
                            <i class="icon-shopping-cart icon-white"></i>
                            [ <span class="totalCartItems">{{ totalCartItems() }}</span>  ]
                        </span>
                    </a>
				</div>
			</div>
		</div>
		<!-- Navbar ================================================== -->
		<section id="navbar">
		  <div class="navbar">
		    <div class="navbar-inner">
		      <div class="container">
		        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		          <span class="icon-bar"></span>
		        </a>
		        <a class="brand" href="{{ url('/') }}">Evisem</a>
		        <div class="nav-collapse">
		          <ul class="nav">
		            <li class="active"><a href="{{ url('/') }}">Accueil</a></li>
                    @foreach ($sections as $section)
                    @if(count($section['categories'])>0)
		            <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">{{ $section['name'] }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @foreach ($section['categories'] as $category)
                                <li class="divider"></li>
                                <li class="nav-header"><a href="{{ url('/'.$category['url']) }}">{{ $category['category_name'] }}</a></li>
                                @foreach ($category['subcategories'] as $subcategory)
                                <li><a href="{{ $subcategory['url'] }}">{{ $subcategory['category_name'] }}</a></li>
                                @endforeach
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
		            <li><a href="#">A propos</a></li>
		          </ul>
		          <form class="navbar-search pull-left" action="#">
		            <input type="text" class="search-query span2" placeholder="Search"/>
		          </form>
		          <ul class="nav pull-right">
		            <li><a href="{{ url('orders') }}">Commandes</a></li>
		            <li class="divider-vertical"></li>
                    @if(Auth::check())
                        <li><a href="{{ url('account') }}">Mon compte</a></li>
                        <li><a href="{{ url('/logout') }}">Se déconnecter</a></li>
                    @else
		                <li><a href="{{ url('/login-register') }}">Se connecter / S'inscrire</a></li>
                    @endif
		          </ul>
		        </div><!-- /.nav-collapse -->
		      </div>
		    </div><!-- /navbar-inner -->
		  </div><!-- /navbar -->
		</section>
	</div>
</div>
