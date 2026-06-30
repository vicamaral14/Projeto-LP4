# 🐾 VetCare - Sistema de Gerenciamento para Clínica Veterinária

## Sobre o Projeto

O **VetCare** é um sistema web desenvolvido como trabalho final da disciplina de **Desenvolvimento Web com PHP** do curso de Ciência da Computação do IFRS.

O sistema foi criado para auxiliar uma clínica veterinária no gerenciamento de informações, permitindo o cadastro e controle de tutores, animais e consultas veterinárias.

O projeto foi desenvolvido utilizando a arquitetura **MVC (Model-View-Controller)**, proporcionando uma melhor organização do código e separação das responsabilidades entre interface, lógica de negócio e acesso aos dados.

### Funcionalidades

- Login de usuários
- Cadastro, edição, listagem e exclusão de tutores
- Cadastro, edição, listagem e exclusão de animais
- Agendamento, edição, listagem e exclusão de consultas
- Dashboard com informações gerais da clínica

---

## Tecnologias Utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- Git e GitHub
- XAMPP

---

# Como Executar o Projeto

## 1. Clonar o repositório

```bash
git clone https://github.com/SEU-USUARIO/Projeto-LP4.git
```

Ou faça o download do projeto em formato `.zip` e extraia os arquivos.

---

## 2. Copiar o projeto

Copie a pasta do projeto para o diretório:

```
C:\xampp\htdocs\
```

---

## 3. Iniciar o XAMPP

Abra o XAMPP Control Panel e inicie os serviços:

- Apache
- MySQL

---

## 4. Criar o banco de dados

Acesse o phpMyAdmin:

```
http://localhost/phpmyadmin
```

Crie um banco de dados chamado:

```
clinica_veterinaria
```

---

## 5. Importar o banco

Importe o arquivo SQL disponibilizado junto ao projeto para criar as tabelas e os dados necessários.

---

## 6. Configurar a conexão

Abra o arquivo:

```
config/conexao.php
```

E configure os dados de acesso ao banco de dados, se necessário.

Exemplo:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "clinica_veterinaria";
```

---

## 7. Executar o sistema

No navegador, acesse:

```
http://localhost/Projeto-LP4
```

Após isso, o sistema estará pronto para utilização.
