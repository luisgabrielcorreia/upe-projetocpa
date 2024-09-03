# Nome do projeto

<img src="imagem.png" alt="Exemplo imagem">

> Um sistema feito para a Universidade de Pernambuco, que permite o gerenciamento de avaliações e votações, com geração automática de relatórios e gráficos para análise de resultados.

### Ajustes e melhorias

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas para as seguintes tarefas:

- [x] Implementação do sistema de votação
- [x] Criação de gráficos para visualização de dados
- [x] Integração com a autenticação do Google
- [ ] Geração de relatórios em PDF/Excel
- [ ] Implementação de um sistema de notificações

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:

- Você instalou a versão mais recente do PHP e MySQL. É recomendado usar PHP 7.4 ou superior e MySQL 5.7 ou superior.
- Você tem uma máquina com Windows ou Linux. O projeto não foi testado em Mac.
- Você leu a documentação do PHP e guia de instalação do MySQL.

## 🚀 Instalando <nome_do_projeto>

Para instalar o upe-projetocpa, siga estas etapas:

Linux e macOS:

Clone o repositório para o seu diretório local:
```
https://github.com/luisgabrielcorreia/upe-projetocpa
```

Navegue até o diretório do projeto:
```
cd upe-projetocpa
```

Instale as dependências necessárias usando Composer:
```
composer install
```

Configure o banco de dados. Importe o arquivo banco_cpa.sql para o seu servidor MySQL.
Configure o arquivo .env com suas credenciais de banco de dados:
```
cp .env.example .env
```

Windows:

Clone o repositório para o seu diretório local:
```
https://github.com/luisgabrielcorreia/upe-projetocpa
```

Navegue até o diretório do projeto:
```
cd upe-projetocpa
```

Instale as dependências necessárias usando Composer:
```
composer install
```

Configure o banco de dados. Importe o arquivo banco_cpa.sql para o seu servidor MySQL.
Configure o arquivo .env com suas credenciais de banco de dados:
```
cp .env.example .env
```

## ☕ Usando upe-projetocpa

Inicie o servidor localmente:

```
php -S localhost:8000
```

Abra seu navegador e acesse:

```
http://localhost:8000
```

## 🤝 Colaboradores

Agradecemos às seguintes pessoas que contribuíram para este projeto:

<table>
  <tr>
    <td align="center">
      <a href="#" title="#">
        <img src="https://www.ecomp.poli.br/wp-content/uploads/2016/07/LuizNova.png" width="100px;" alt="Foto do Luis Menezes"/><br>
        <sub>
          <b>Luis Menezes</b>
        </sub>
      </a>
    </td>
    <td align="center">
      <a href="#" title="#">
        <img src="https://th.bing.com/th/id/OIP._Y-9-Pw-8JxeSFYy3baznAHaFj?rs=1&pid=ImgDetMain" width="100px;" alt="Foto do Luis Gabriel Correia"/><br>
        <sub>
          <b>Luis Gabriel Correia</b>
        </sub>
      </a>
    </td>
  </tr>
</table>

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.
