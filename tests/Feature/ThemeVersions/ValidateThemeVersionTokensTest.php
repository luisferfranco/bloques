<?php

use App\Actions\ThemeVersions\ValidateThemeVersionTokens;
use App\Models\DesignTokenSchema;
use App\Models\Theme;
use App\Models\ThemeVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
  $this->makeVersion = function (array $contract, array $values): ThemeVersion {
    $schema = new DesignTokenSchema();
    $schema->definition = ['tokens' => $contract];

    $version = new ThemeVersion();
    $version->setRelation('designTokenSchema', $schema);
    $version->tokens = $values;

    return $version;
  };

  $this->validator = app(ValidateThemeVersionTokens::class);
});

it('accepts tokens that comply with the contract', function () {
  $version = ($this->makeVersion)(
    [
      'primary' => ['type' => 'color', 'required' => true],
      'font-body' => ['type' => 'font-family', 'required' => true],
      'radius-md' => ['type' => 'length', 'required' => true],
      'shadow-md' => ['type' => 'shadow', 'required' => true],
    ],
    [
      'primary' => '#2563eb',
      'font-body' => 'Inter, sans-serif',
      'radius-md' => '0.5rem',
      'shadow-md' => '0 4px 6px rgb(0 0 0 / 0.1)',
    ],
  );

  $this->validator->handle($version);

  expect(true)->toBeTrue();
});

it('rejects missing required tokens', function () {
  $version = ($this->makeVersion)(
    [
      'primary' => ['type' => 'color', 'required' => true],
    ],
    [],
  );

  expect(fn () => $this->validator->handle($version))
    ->toThrow(ValidationException::class);
});

it('rejects invalid color values', function () {
  $version = ($this->makeVersion)(
    [
      'primary' => ['type' => 'color', 'required' => true],
    ],
    [
      'primary' => 'blue',
    ],
  );

  expect(fn () => $this->validator->handle($version))
    ->toThrow(ValidationException::class);
});

it('rejects unknown tokens', function () {
  $version = ($this->makeVersion)(
    [
      'primary' => ['type' => 'color', 'required' => true],
    ],
    [
      'primary' => '#2563eb',
      'unknown-token' => '#ffffff',
    ],
  );

  expect(fn () => $this->validator->handle($version))
    ->toThrow(ValidationException::class);
});

it('rejects empty values', function () {
  $version = ($this->makeVersion)(
    [
      'font-body' => ['type' => 'font-family', 'required' => true],
    ],
    [
      'font-body' => '',
    ],
  );

  expect(fn () => $this->validator->handle($version))
    ->toThrow(ValidationException::class);
});

it('rejects values with an incompatible type', function () {
  $version = ($this->makeVersion)(
    [
      'radius-md' => ['type' => 'length', 'required' => true],
    ],
    [
      'radius-md' => '#ffffff',
    ],
  );

  expect(fn () => $this->validator->handle($version))
    ->toThrow(ValidationException::class);
});

function createThemeVersionForTest(array $tokens): ThemeVersion
{
  $theme = Theme::forceCreate([
    'name' => 'Tema de prueba',
    'slug' => 'tema-prueba',
  ]);

  $schema = DesignTokenSchema::forceCreate([
    'name' => 'default',
    'version' => '1.0.0',
    'definition' => [
      'tokens' => [
        'primary' => [
          'type' => 'color',
          'required' => true,
        ],
      ],
    ],
    'is_active' => true,
    'published_at' => now(),
  ]);

  return new ThemeVersion([
    'theme_id' => $theme->id,
    'design_token_schema_id' => $schema->id,
    'version' => '1.0.0',
    'tokens' => $tokens,
  ]);
}

it('prevents saving a theme version with invalid tokens', function () {
  $version = createThemeVersionForTest([
    'primary' => 'blue',
  ]);

  expect(fn () => $version->save())
    ->toThrow(ValidationException::class);

  $this->assertDatabaseMissing('theme_versions', [
    'version' => '1.0.0',
  ]);
});

it('saves a theme version with valid tokens', function () {
  $version = createThemeVersionForTest([
    'primary' => '#2563eb',
  ]);

  expect($version->save())->toBeTrue();

  $this->assertDatabaseHas('theme_versions', [
    'id' => $version->id,
    'version' => '1.0.0',
  ]);
});