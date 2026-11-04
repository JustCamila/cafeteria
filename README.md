# ☕ Cafeteria Gourmet

Sistema web para gestão de uma cafeteria de cafés especiais: clientes, produtos, categorias, pedidos e estoque. Desenvolvido em **Laravel** (padrão MVC) com banco **PostgreSQL 17** hospedado no **Neon**.

Projeto Avaliativo do 2º Bimestre de 2026 — Engenharia de Software, Centro Universitário Campo Real.
Disciplinas: **Banco de Dados II** (Prof. Bruno Dion) e **Desenvolvimento Back-End** (Prof. Dionatan Inhoato).

---

## Equipe

| Integrante | Responsabilidade |
| --- | --- |
| Camila | Banco de dados, Neon, DER, migrations, seeders, índices, Models, projeto Laravel base, relatório e README |
| Leticia | Functions, stored procedures, triggers, Services de integração com o banco e telas de demonstração |
| João | CRUD web (Resource Controllers, Form Requests, Services de lógica de negócio e views Blade) |
| Rhauan | API REST, testes automatizados, coleção do Postman, backup/restauração |

--- 

## Instalação

### Passo a passo

```bash
# 1. Clonar o repositório
git clone https://github.com/JustCamila/cafeteria.git
cd cafeteria

# 2. Instalar as dependências
composer install

# 3. Criar o arquivo de ambiente e gerar a chave da aplicação
cp .env.example .env
php artisan key:generate

# 4. Preencher o .env com os dados do Neon e testar a conexão
php artisan db:show

# 5. Criar as tabelas, os objetos do banco e carregar os dados
php artisan migrate:fresh --seed

# 6. Subir o servidor
php artisan serve
```
