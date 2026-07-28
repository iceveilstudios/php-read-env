# ICV Env - PHP READ ENV

Leitor de variáveis de ambiente (`.env`) para PHP puro — parte do ecossistema **Iceveil Core (ICV)**.

Zero dependências. Zero Composer obrigatório. Feito para funcionar sem dor de cabeça em hospedagens compartilhadas limitadas (ex: InfinityFree), onde nem sempre dá pra rodar `composer install` no servidor.

## Por quê

A maioria das libs de `.env` no ecossistema PHP assume um ambiente robusto (VPS, Docker, CI). O ICV Env foi feito pro cenário oposto: hosts grátis ou baratas, sem shell, sem controle total do ambiente — só upload de arquivo e PHP puro.

## Instalação

Baixe ou clone este repositório e copie a pasta `src/` para dentro do seu projeto. Depois, inclua manualmente:

```php
require __DIR__ . '/src/Env.php';
require __DIR__ . '/src/helpers.php';
```

Sem Composer, sem autoload mágico, sem passo de build — funciona em qualquer hospedagem que rode PHP puro.

## Uso

Crie um `.env` na raiz do projeto:

```env
API_KEY=abc123
DATA_PATH=/data
DEBUG=true
```

No seu código:

```php
use Iceveil\Env\ICVEnv;

ICVEnv::load();

$apiKey = env('API_KEY');
$dataPath = env('DATA_PATH', __DIR__ . '/data'); // com fallback
```

Se preferir, use `icv_env()` no lugar de `env()` para evitar conflito com outras libs que também declarem essa função global.

## Segurança

Sempre bloqueie o acesso direto ao `.env` via `.htaccess`:

```apache
<Files ".env">
    Order allow,deny
    Deny from all
</Files>
```

E nunca versione seu `.env` real — use um `.env.example` como referência.

## Licença

MIT — Iceveil Studios.
