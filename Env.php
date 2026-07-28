<?php
/**
 * ICV Env — Leitor de variáveis de ambiente (.env) para PHP puro.
 *
 * Parte do ecossistema Iceveil Core (ICV).
 * Zero dependências. Compatível com hospedagens compartilhadas
 * limitadas (ex: InfinityFree) — sem Composer obrigatório.
 *
 * @package   Iceveil\Env
 * @author    Iceveil Studios <https://github.com/iceveilstudios>
 * @license   MIT
 */

declare(strict_types=1);

namespace Iceveil\Env;

class ICVEnv
{
    /** @var array<string, string> */
    private static array $data = [];

    private static bool $loaded = false;

    /**
     * Carrega o arquivo .env para memória.
     */
    public static function load(?string $path = null): void
    {
        if (self::$loaded) {
            return;
        }

        $path = $path ?? dirname(__DIR__, 3) . '/.env';

        if (!file_exists($path)) {
            throw new \RuntimeException("[ICVEnv] Arquivo .env não encontrado em: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            self::$data[$key] = $value;
            $_ENV[$key] = $value;
            putenv("{$key}={$value}");
        }

        self::$loaded = true;
    }

    /**
     * Retorna o valor de uma variável, com fallback opcional.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$data[$key] ?? $default;
    }

    /**
     * Verifica se uma chave existe no .env carregado.
     */
    public static function has(string $key): bool
    {
        if (!self::$loaded) {
            self::load();
        }

        return array_key_exists($key, self::$data);
    }

    /**
     * Reseta o estado interno (útil em testes).
     */
    public static function reset(): void
    {
        self::$data = [];
        self::$loaded = false;
    }
}
