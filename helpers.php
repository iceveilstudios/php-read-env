<?php
/**
 * ICV Env — Helpers globais.
 * Parte do ecossistema Iceveil Core (ICV).
 *
 * Se você não usa Composer, dá pra incluir só este arquivo
 * junto com Env.php via require — não precisa de autoload.
 */

declare(strict_types=1);

use Iceveil\Env\ICVEnv;

if (!function_exists('env')) {
    /**
     * Atalho global para Iceveil\Env\ICVEnv::get()
     */
    function env(string $key, mixed $default = null): mixed
    {
        return ICVEnv::get($key, $default);
    }
}

if (!function_exists('icv_env')) {
    /**
     * Alias explícito com prefixo ICV, para evitar conflito
     * de nome com a função env() de outras libs no mesmo projeto.
     */
    function icv_env(string $key, mixed $default = null): mixed
    {
        return ICVEnv::get($key, $default);
    }
}
