<?php

namespace App\Actions\ThemeVersions;

use App\Models\ThemeVersion;
use Illuminate\Validation\ValidationException;

class ValidateThemeVersionTokens
{
  public function handle(ThemeVersion $themeVersion): void
  {
    $definition = $themeVersion->designTokenSchema?->definition;
    $contract   = $definition['tokens'] ?? null;
    $values     = $themeVersion->tokens;

    if (! is_array($contract) || ! is_array($values)) {
      throw ValidationException::withMessages([
        'tokens' => 'El contrato o los valores de tokens no tienen una estructura válida.',
      ]);
    }

    $errors = [];

    foreach ($contract as $name => $rules) {
      if (! is_array($rules) || ! isset($rules['type'])) {
        $errors[] = "El contrato contiene una definición inválida para [{$name}].";

        continue;
      }

      if (! array_key_exists($name, $values)) {
        if ($rules['required'] ?? false) {
          $errors[] = "Falta el token obligatorio [{$name}].";
        }

        continue;
      }

      $value = $values[$name];

      if (! is_string($value) || ! $this->isValidValue($rules['type'], $value)) {
        $errors[] = "El token [{$name}] no tiene un valor válido para el tipo [{$rules['type']}].";
      }
    }

    $unknownTokens = array_diff(array_keys($values), array_keys($contract));

    foreach ($unknownTokens as $name) {
      $errors[] = "El token [{$name}] no está definido en el contrato.";
    }

    if ($errors !== []) {
      throw ValidationException::withMessages([
        'tokens' => $errors,
      ]);
    }
  }

  private function isValidValue(string $type, string $value): bool
  {
    if (trim($value) === '') {
      return false;
    }

    return match ($type) {
      'color' => (bool) preg_match('/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value),

      'font-family' => true,

      'length' => (bool) preg_match(
        '/^(?:0|(?:\d+(?:\.\d+)?|\.\d+)(?:px|rem|em|%|vw|vh|svw|svh|dvw|dvh|ch|ex|pt|pc|in|cm|mm))$/',
        $value,
      ),

      'shadow' => true,

      default => false,
    };
  }
}
