# Laravel Model Timeline

Um sistema robusto e polimórfico de Histórico e Timeline para Models Eloquent. Ideal para ERPs, CRMs e sistemas que necessitam de rastreabilidade detalhada de ações (Auditoria e Comentários).

## 🚀 Funcionalidades

- **Polimórfico:** Funciona em qualquer Model (Clientes, Vendas, Mensalidades, etc).
- **Atores Automáticos:** Identifica automaticamente o usuário logado (`Auth::user()`).
- **Eventos de Sistema:** Suporta ações realizadas por rotinas automáticas (Cron Jobs) sem usuário atrelado.
- **Metadados JSON:** Armazena dados técnicos (ex: `old_value`, `new_value`, `ip_address`) sem sujar a tabela principal.
- **Comentários:** Helper simples para adicionar observações manuais (estilo CRM).

## 📦 Instalação

Instale o pacote via Composer:

```bash
composer require erppackages/laravel-model-timeline

```
Em seguida, rode as migrations para criar a tabela model_timelines

```bash
php artisan migrate

```

## ⚙️ Configuração

Adicione a Trait HasTimeline no Model que você deseja rastrear.

Exemplo em uma Mensalidade:

```bash
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ErpPackages\ModelTimeline\Traits\HasTimeline; // <--- Importe a Trait

class Mensalidade extends Model
{
    use HasTimeline; // <--- Use a Trait

    // ...
}

```

## 📚 Como Usar

1. Registrando um Evento Genérico
Use o método recordTimeline.

```bash
$mensalidade = Mensalidade::find(1);

$mensalidade->recordTimeline(
    description: 'Data de vencimento alterada para 15/05',
    action: 'update', // Opcional (default: 'info')
    metadata: ['old' => '10/05', 'new' => '15/05'] // Opcional
);

```

2. Registrando Comentários (CRM)
Ideal para observações de atendimento ao cliente.

```bash
$mensalidade->comment("Cliente ligou pedindo para segurar o boleto.");

```

3. Eventos de Sistema (Sem Usuário Logado)
Se o código rodar em uma Cron Job ou Queue, o pacote define o actor como NULL automaticamente, indicando uma ação do sistema.

```bash
$novaMensalidade->recordTimeline(
    description: 'Renovação automática de contrato',
    action: 'system_event'
);

```

4. Forçando um Ator Específico
Você pode passar um usuário específico caso esteja "impersonando" ou rodando um comando administrativo.

```bash
$admin = User::find(1);

$mensalidade->recordTimeline(
    description: 'Alteração forçada pelo suporte',
    actor: $admin
);

```

## 🔍 Recuperando o Histórico
Para exibir no Frontend (Blade/Vue/React):

```bash
$historico = $mensalidade->timeline()
    ->with('actor') // Traz os dados do usuário que fez a ação
    ->get();

foreach ($historico as $entry) {
    echo $entry->created_at->format('d/m/Y H:i');
    echo " - " . $entry->description;
    
    // Verifica se foi usuário ou sistema
    echo " (Por: " . ($entry->actor ? $entry->actor->name : 'Sistema') . ")";
}

```

## 🛠 Estrutura do Banco de Dados
A tabela model_timelines possui a seguinte estrutura:

<img width="536" height="336" alt="image" src="https://github.com/user-attachments/assets/3543e099-ea47-433c-a57a-f6a96209cc5f" />


## 📄 Licença
MIT License.

## Contato
erichfr1@hotmail.com
