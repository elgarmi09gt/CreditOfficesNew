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
Route::get('e_autocomplete/{pays?}', 'ServiceController@listeEntreprises')->name('autocompleteEntreprise');
Route::get('s_autocomplete/{pays?}', 'ServiceController@listeSecteurs')->name('autocompleteSector');
Route::get('r_autocomplete/{pays?}', 'ServiceController@listeRatios')->name('autocompleteRatio');
/*
 * Route for import export
 */