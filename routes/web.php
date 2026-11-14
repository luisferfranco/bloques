<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

// Página de inicio del tenant
Route::livewire('/{tenant:slug}', "pages::page")
  ->where('tenant', '(?!admin(?:/|$)|login(?:/|$)|register(?:/|$))[a-z0-9-]+')
  ->name('pages.home');

// Cualquier otra página del tenant
Route::livewire('/{tenant:slug}/{page:slug}', "pages::page")
  ->where('tenant', '(?!admin(?:/|$)|login(?:/|$)|register(?:/|$))[a-z0-9-]+')
  ->name('pages.show');