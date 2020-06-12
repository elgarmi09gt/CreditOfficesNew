<?php

Route::get('/', 'HController@index')->name('home');

#################### Route to analyses ########################
/*
 * For Entreprises
 */
Route::get('/bilan_entreprise/{pays?}', 'EntrepriseController@index_bilan')->name('entreprise.bilan.create');
Route::get('/bilan_df_entreprise/{pays?}', 'EntrepriseController@index_bilan_diff')->name('entreprise.df.bilan.create');
Route::get('/bilan_poste_entreprise/{pays?}', 'EntrepriseController@index_bilan_post')->name('entreprise.poste.bilan.create');

Route::post('/bilan_entreprise', 'EntrepriseController@bilan')->name('entreprise.bilan.store');
Route::post('/bilan_df_entreprise', 'EntrepriseController@bilan_diff')->name('entreprise.df.bilan.store');
Route::post('/bilan_poste_entreprise', 'EntrepriseController@bilan_post')->name('entreprise.poste.bilan.store');
/*
*	For Groupe
*/
Route::get('/bilan_groupe', 'GroupeController@index_bilan')->name('groupe.bilan.create');

Route::post('/bilan_groupe', 'GroupeController@bilan')->name('groupe.bilan.store');
/*
 * For Activities
 */
Route::get('/bilan_sa/{pays?}', 'SectorActivityController@index_bilan')->name('sa.bilan.create');
Route::get('/bilan_df_sa/{pays?}', 'SectorActivityController@index_bilan_df')->name('sa.bilan.df.create');
Route::get('/bilan_poste_sa/{pays?}', 'SectorActivityController@index_bilan_post')->name('sa.bilan.poste.create');

Route::post('/bilan_sa', 'SectorActivityController@bilan')->name('sa.bilan.store');
Route::post('/bilan_df_sa', 'SectorActivityController@bilan_df')->name('sa.df.bilan.store');
Route::post('/bilan_poste_sa', 'SectorActivityController@bilan_post')->name('sa.poste.bilan.store');
/*
 * For Ratios
 */
Route::get('/ratios/{pays?}', 'RatioController@index_ratio')->name('entreprise.ratio.create');
Route::get('/ratios_res/{pays?}', 'RatioController@index_ratios_res')->name('entreprise.ratios_res.create');

Route::post('/ratios', 'RatioController@ratio')->name('ratio.store');
Route::post('/ratios_res', 'RatioController@ratio_res')->name('ratios_res.store');
/*
 * Route for Service Supplement
 */
// Route::get('e_autocomplete/{pays?}', 'ServiceController@listeEntreprises')->name('autocompleteEntreprise');
Route::get('s_autocomplete/{pays?}', 'ServiceController@listeSecteurs')->name('autocompleteSector');
Route::get('r_autocomplete/{pays?}', 'ServiceController@listeRatios')->name('autocompleteRatio');
Route::get('g_autocomplete', 'ServiceController@listeGroupes')->name('autocompleteGroupe');
/*
 * Route for import export
 */

/** All Entreprise traitement */
Route::namespace('Entreprise')->prefix('entreprise')->as('entreprise.')->group(function () {

    // Simple Bilan
    Route::post('/bilan', [
        'uses' => 'AnalyseFinancierController@bilan',
        'as' => 'bilan.store',
    ]);

    // Bilan Comparaison
    Route::post('/bilan_df', [
        'uses' => 'AnalyseFinancierController@bilan_diff',
        'as' => 'df.bilan.store',
    ]);

    // Bilan Par Poste
    Route::post('/bilan_poste', [
        'uses' => 'AnalyseFinancierController@bilan_post',
        'as' => 'poste.bilan.store',
    ]);
});

/**
 * For Banque
 */
Route::namespace('Banque')->prefix('banque')->as('banque.')->group(function () {

    // Simple Bilan
    Route::get('/bilan/{pays?}', [
        'uses' => 'AnalyseFinancierController@index',
        'as' => 'bilan.create'
    ]);

    // Bilan Comparaison
    Route::get('/bilan_df/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_diff',
        'as' => 'df.bilan.create'
    ]);

    // Bilan Par Poste
    Route::get('/bilan_poste/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_post',
        'as' => 'poste.bilan.create'
    ]);

    Route::get('/ratios/{pays?}', [
        'uses' => 'RatioController@index',
        'as' => 'ratio.create'
    ]);

});

// AutoCompléte liste Entreprise
Route::get('b_autocomplete/{pays?}', [
    'uses' => 'ServiceController@listeBanques',
    'as' => 'autocompleteBanque'
]);
Route::get('a_autocomplete/{pays?}', [
    'uses' => 'ServiceController@listeAgregats',
    'as' => 'autocompleteAgragat'
]);

Route::get('sys_autocomplete/{pays?}', [
    'uses' => 'ServiceController@listeSyscoas',
    'as' => 'autocompleteSyscoa',
]);
Route::get('sec_autocomplete/{pays?}', [
    'uses' => 'ServiceController@listeSecteurs',
    'as' => 'autocompleteSector',
]);

Route::get('post_b_autocomplete/{pays?}', [
    'uses' => 'ServiceController@listePostesB',
    'as' => 'autocompletePosteBanque',
]);

Route::post('/autocomplete-postes/{pays?}', [
    'uses' => 'ServiceController@fetchPostes',
]);

Route::post('/autocomplete-postes-syscoa/{pays?}', [
    'uses' => 'ServiceController@fetchPostesSyscoa',
]);


/**
 * For SYSCOA
 */
Route::namespace('Syscoa')->prefix('syscoa')->as('syscoa.')->group(function () {

    // Simple Bilan
    Route::get('/bilan_syscoa/{pays?}', [
        'uses' => 'AnalyseFinancierController@index',
        'as' => 'bilan.create',
    ]);

    // Bilan Comparaison
    Route::get('/bilan_df_syscoa/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_diff',
        'as' => 'df.bilan.create',
    ]);

    // Bilan Par Poste
    Route::get('/bilan_poste_syscoa/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_post',
        'as' => 'poste.bilan.create',
    ]);

});
/*
 * For Sector
 * */
Route::namespace('Secteur')->prefix('secteur')->as('secteur.')->group(function () {

    // Simple Bilan
    Route::get('/bilan_secteur/{pays?}', [
        'uses' => 'AnalyseFinancierController@index',
        'as' => 'bilan.create',
    ]);
    Route::post('/bilan', [
        'uses' => 'AnalyseFinancierController@bilan',
        'as' => 'bilan.store',
    ]);
    // Bilan Comparaison
    Route::get('/bilan_df_secteur/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_diff',
        'as' => 'df.bilan.create',
    ]);
    Route::post('/bilan_df', [
        'uses' => 'AnalyseFinancierController@bilan_diff',
        'as' => 'df.sector.store',
    ]);
    // Bilan Par Poste
    Route::get('/bilan_poste_secteur/{pays?}', [
        'uses' => 'AnalyseFinancierController@index_bilan_post',
        'as' => 'poste.bilan.create',
    ]);
    Route::post('/bilan_poste', [
        'uses' => 'AnalyseFinancierController@bilan_post',
        'as' => 'poste.sector.store',
    ]);
});

Route::namespace('Macro')->prefix('macro')->as('macro.')->group(function () {

    Route::get('/agregat/{pays?}', [
        'uses' => 'MacroAgregatController@index',
        'as' => 'agregat.create',
    ]);

    Route::post('/agregat', [
        'uses' => 'MacroAgregatController@store',
        'as' => 'agregat.store',
    ]);

    Route::get('/agregat_df/{pays?}', [
        'uses' => 'MacroAgregatController@index',
        'as' => 'df.agregat.create',
    ]);

    Route::post('/agregat_df', [
        'uses' => 'MacroAgregatController@store',
        'as' => 'agregat_df.store',
    ]);
});