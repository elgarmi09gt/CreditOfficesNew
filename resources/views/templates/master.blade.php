<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Africa B.I.C - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{asset('images/Senegal.ico')}}" />

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.0/jquery.typeahead.css"
        integrity="sha256-N5LjnCD3sm17vjUaBNSBY/NCdnsUZpSrLurmlYiQgRI=" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"
        integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>
    
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js')}}">
        </script>

    
    </head>
<body>
<div class="header">
    <div id="nav">  <!-- début menu -->
        {{-- <li>
            <a href="#">Registre de commerce</a>
            <ul>
                <li>
                    <a href="#"><span>Immatriculation</span></a>
                    <ul>
                        <li>
                            <a href="#"><span>SA</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SARL</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SNC</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SCS</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SF</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SP</span></a>
                        </li>
                        <li>
                            <a href="#"><span>G.I.E</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Personnes Physiques</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#"><span> Modification</span></a>
                    <ul>
                        <li>
                            <a href="#"><span>SA</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SARL</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SNC</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SCS</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SF</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SP</span></a>
                        </li>
                        <li>
                            <a href="#"><span>G.I.E</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Personnes Physiques</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#"><span>  Radiation</span></a>
                    <ul>
                        <li>
                            <a href="#"><span>SA</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SARL</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SNC</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SCS</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SF</span></a>
                        </li>
                        <li>
                            <a href="#"><span>SP</span></a>
                        </li>
                        <li>
                            <a href="#"><span>G.I.E</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Personnes Physiques</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><span>D&eacute;pot des comptes</span></a>
                </li>
                <li>
                    <a href="#"><span>Formulaire et models</span></a>
                </li>
                <li>
                    <a href="#"><span>RCCM Internationaux</span></a>
                </li>
            </ul>
        </li> --}}
        <li>
            <a href="#">BANQUES</a>
            <ul>
                <li><a href="#"><span>ANALYSE FINACIER</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('banque.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="{{ route('banque.df.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Comparaison</span></a>
                        </li>
                        <li>
                            <a href="{{ route('banque.poste.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Poste</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Agr&eacute;gats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="{{ route('entreprise.ratios_res.create',['pays' => $pays])}}">
                                <span>Agr&eacute;gats Finaciers D&eacute;taill&eacute;</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Comptabilit&eacute; Nationale</span></a>
                        </li>
                        <li>
                            <a href="{{ route('entreprise.ratio.create', ['pays' => $pays])}}">
                                <span>Ratios</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#">RECHERCHE</a></li>
                <li><a href="#">STATISTIQUES</a></li>
                <li><a href="#">ESPACE ACTEURS</a></li>
            </ul>
        </li>
        <li>
            <a href="#">SYSCOA</a>
            <ul>
                <li><a href="#"><span>ANALYSE FINACIER</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('syscoa.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="{{ route('syscoa.df.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Comparaison</span></a>
                        </li>
                        <li>
                            <a href="{{ route('syscoa.poste.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Poste</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Agr&eacute;gats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="{{ route('entreprise.ratios_res.create',['pays' => $pays])}}">
                                <span>Agr&eacute;gats Finaciers D&eacute;taill&eacute;</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Comptabilit&eacute; Nationale</span></a>
                        </li>
                        <li>
                            <a href="{{ route('entreprise.ratio.create', ['pays' => $pays])}}">
                                <span>Ratios</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#">RECHERCHE</a></li>
                <li><a href="#">STATISTIQUES</a></li>
                <li><a href="#">ESPACE ACTEURS</a></li>
            </ul>
        </li>
        <li>
            <a href="#">GROUPE</a>
            <ul>
                <li><a href="#"><span>ANALYSE FINACIER</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('groupe.bilan.create')}}">
                                <span>Etats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Etats Finaciers - Comparaison</span></a>
                        </li>
                        <li>
                                <span>Etats Finaciers - Poste</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Agr&eacute;gats Finaciers</span></a>
                        </li>
                        <li>
                                <span>Agr&eacute;gats Finaciers D&eacute;taill&eacute;</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Comptabilit&eacute; Nationale</span></a>
                        </li>
                        <li>
                                <span>Ratios</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#">RECHERCHE</a></li>
                <li><a href="#">STATISTIQUES</a></li>
                <li><a href="#">ESPACE ACTEURS</a></li>
            </ul>
        </li>
        <li>
            <a href="#">SECTEUR D&apos;ACTIVIT&Eacute</a>
            <ul>
                <li><a href="#"><span>ANALYSE FINACIER</span></a>
                    <ul>
                        <li>
                            <a href="{{ route('secteur.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="{{ route('secteur.df.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Comparaison</span></a>
                        </li>
                        <li>
                            <a href="{{ route('secteur.poste.bilan.create',['pays' => $pays])}}">
                                <span>Etats Finaciers - Poste</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Agr&eacute;gats Finaciers</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Agr&eacute;gats Finaciers D&eacute;taill&eacute;</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Comptabilit&eacute; Nationale</span></a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Ratios</span></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#">RECHERCHE</a></li>
                <li><a href="#">STATISTIQUES</a></li>
                <li><a href="#">ESPACE ACTEURS</a></li>
            </ul>
        </li>
        {{-- <li>
            <a href="#">Partenaires Economiques</a>
            <ul>
                <li><a href="#">CHAMBRES DE COMMERCES </a>
                    <ul>
                        <li><a href="#">Ch-Com de Dakar</a></li>
                        <li><a href="#">Ch-Com de Diourbel</a></li>
                        <li><a href="#">Ch-Com de Fatick</a></li>
                        <li><a href="#">Ch-Com de Kaolack</a></li>
                        <li><a href="#">Ch-Com de Kédougou</a></li>
                        <li><a href="#">Ch-Com de Kolda</a></li>
                        <li><a href="#">Ch-Com de Louga</a></li>
                        <li><a href="#">Ch-Com de Matam</a></li>
                        <li><a href="#">Ch-Com de Saint Louis</a></li>
                        <li><a href="#">Ch-Com de Tambacounda</a></li>
                        <li><a href="#">Ch-Com de Thiès</a></li>
                        <li><a href="#">Ch-Com de Vélinguara</a></li>
                        <li><a href="#">Ch-Com de Ziguinchor</a></li>
                    </ul>
                </li>
                <li><a href="#">APIX</a></li>
                <li><a href="#">NOTAIRES</a></li>
                <li><a href="#">IPRES</a></li>
                <li><a href="#">CAISSE DE SECURITE SOCIALE</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Partenaires Sociaux</a>
            <ul>
                <li><a href="#">ANDS</a></li>
                <li><a href="#">CHAMBRE DES METIERS</a></li>
                <li><a href="#">MINISTERES</a>
                    <ul>
                        <li><a href="#">de l'industrie et de l'artisanat</a></li>
                        <li><a href="#">de l'emploie</a></li>
                    </ul>
                </li>
                <li><a href="#">PATRONAT</a>
                    <ul>
                        <li><a href="#">MEDES</a></li>
                        <li><a href="#">CNP</a></li>
                        <li><a href="#">CNES</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">Privil&eacute;ges et Nantissements</a>
            <ul>
                <li><a href="#">
                        Inscription de privilèges et Nantissements </a></li>
                <li><a href="#">
                        Rediation de Privilèges et Nantissments</a></li>
                <li><a href="#">
                        Information sur les Privilèges et Nantissements </a></li>
                <li><a href="#">Tarif des Privilèges et Nantissements</a></li>
            </ul>
        </li> --}}
        <li>
            <a href="{{ route('macro.agregat.create',['pays' => $pays])}}">MACROS</a>
        </li>
    </div>   <!-- fin menu -->
</div>
<div class="#">
    <br/>
    <div class="container " id="container">
        <div class="card">
            {{-- Information d'entete ici --}}
            @yield("header")
            {{-- Formulaires de recherche ici--}}
            @yield("forms")
        </div>
<br>
    {{-- Contenu ici --}}
    @yield("content")
</div>
<div class="#">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Footer -->
    <footer class="page-footer font-smaller blue ">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-4" style="font-family: 'Times New Roman';font-size: large">© 2019 Copyright:
            <a href="#">Analyse Financière</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
</div>
</div>
</body>
</html>
