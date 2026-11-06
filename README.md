# Neymar Jr. — Joga bonito. Faz história.

Uma experiência responsiva sobre a trajetória de Neymar Jr., com linha do tempo, conquistas, quiz de futebol e ranking de pontuações.

## Requisitos

- PHP 8.2+
- Composer
- Node.js e npm
- SQLite (configuração padrão) ou outro banco compatível com Laravel

## Como executar

1. Instale as dependências PHP e JavaScript:

   ```sh
   composer install
   npm install
   ```

2. No PowerShell, crie o arquivo de ambiente, configure a chave e prepare o banco:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

   O seeder cria as perguntas dos três níveis. Configure as variáveis `DB_*` no `.env` se não for usar SQLite.

3. Compile os assets e inicie o servidor:

   ```sh
   npm run build
   php artisan serve
   ```

   Acesse `http://127.0.0.1:8000`.

Durante o desenvolvimento, use `npm run dev` em um terminal e `php artisan serve` em outro.

## Conta, quiz e ranking

É necessário criar uma conta com nome, e-mail e senha, ou entrar com uma conta existente, para iniciar o quiz. Cada candidato aparece uma única vez no ranking, com sua melhor pontuação; somente nome, nível, acertos e pontos são exibidos publicamente. A senha é armazenada com hash e o e-mail nunca aparece no ranking.

O quiz oferece cinco perguntas aleatórias por partida, nos níveis fácil, médio e difícil, com 15 segundos para cada resposta. O servidor valida as respostas e calcula pontos considerando acertos, tempo e dificuldade. Perguntas ficam na tabela `quiz_questions` e melhores pontuações vinculadas à conta ficam na tabela `quiz_scores`.

Para executar os testes:

```sh
php artisan test
```
