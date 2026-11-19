<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

// Páginas reservadas en config/routing.php
$reservedTenantSlugs = implode(
  '|',
  array_map(
    fn (string $slug): string => preg_quote($slug, '/'),
    config('routing.reserved_tenant_slugs'),
  ),
);

$tenantSlugPattern = '(?!(?:' . $reservedTenantSlugs . ')(?:/|$))[a-z0-9-]+';

// Página de inicio del tenant
Route::livewire('/{tenant:slug}', "pages::page")
  ->where('tenant', $tenantSlugPattern)
  ->name('pages.home');

// Cualquier otra página del tenant
Route::livewire('/{tenant:slug}/{page:slug}', "pages::page")
  ->where('tenant', $tenantSlugPattern)
  ->name('pages.show');