# Ordem Paranormal Homepage

Homepage dinâmica e totalmente gerenciável para fãs do universo Ordem Paranormal.

## Funcionalidades
- **Seções dinâmicas:** Todos os títulos, subtítulos, textos, cores, imagens e links das seções são editáveis pelo admin.
- **Cards/Boxes dinâmicos:** Crie, edite e exclua múltiplos cards por seção (Funcionalidades, Benefícios, Planos, Campanhas, Sobre) com cor, imagem, texto, link e preço.
- **Newsletter e Footer dinâmicos:** Título, texto, botão e imagem editáveis pelo admin.
- **FAQ dinâmico:** CRUD de múltiplos tópicos, exibidos como accordion na home.
- **Upload de imagens:** Upload seguro para cada seção e card.
- **Admin seguro:** Login para gerenciamento de conteúdo.

## Estrutura do Projeto
```
ordem-paranormal-homepage/
├── app/
│   ├── controllers/
│   ├── css/
│   ├── factory/
│   ├── includes/
│   ├── js/
│   ├── views/
│   │   └── admin/
├── assets/
│   ├── fonts/
│   ├── img/
├── database/
│   ├── estrutura_secoes.sql
│   ├── estrutura_cards.sql
├── public/
│   └── uploads/
├── index.php
├── config.php
```

## Instalação
1. **Clone o repositório:**
   ```
   git clone <url>
   ```
2. **Configure o banco de dados:**
   - Importe `database/estrutura_secoes.sql` e `database/estrutura_cards.sql` no seu MySQL (pode usar o MySQL Workbench).
3. **Configure o acesso ao banco:**
   - Edite `config.php` com as credenciais do seu MySQL.
4. **Acesse o admin:**
   - Usuário padrão: `admin`
   - Senha padrão: `admin123` (altere após o primeiro login)
5. **Acesse a homepage:**
   - Via `index.php` no navegador ou localhost.

## Como usar
- Faça login no admin para editar qualquer seção.
- Use o botão "Gerenciar Cards/Boxes" para criar/editar cards dinâmicos.
- Use o botão "Gerenciar Tópicos FAQ" para editar o FAQ.
- Todas as alterações são refletidas instantaneamente na homepage.

## Tecnologias
- PHP 7+
- MySQL
- Bootstrap 5
- TinyMCE (editor richtext)
- CSS customizado

## Licença
Projeto de fã, sem fins lucrativos, sem vínculo oficial com a série Ordem Paranormal.
