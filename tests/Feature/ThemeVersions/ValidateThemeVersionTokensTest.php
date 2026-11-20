<?php

use App\Actions\ThemeVersions\ValidateThemeVersionTokens;
use App\Models\DesignTokenSchema;
use App\Models\ThemeVersion;
use Illuminate\Validation\ValidationException;

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
