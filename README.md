# PTRVT Blog Module

Módulo personalizado para Magento 2.4.7 que permite gestionar **Posts** con sus **Comentarios** desde el administrador, además de exponerlos vía **REST API** y **GraphQL**.

---

## 🚀 Características

- Al instalar el módulo se genera automáticamente un post inicial de ejemplo (“Hello World” o similar),
- CRUD de Posts desde el Admin (con formulario y grid).
- Vista de Post en modo lectura con listado de comentarios relacionados.
- API REST para obtener posts y comentarios.
- API GraphQL para consultar posts y sus comentarios.
- Arquitectura extensible (Repository pattern + DataProviders).

---

## ⚙️ Instalación

1. Copiar el módulo en `app/code/PTRVT/Blog`
2. Ejecutar los comandos:

```bash
bin/magento module:enable PTRVT_Blog
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:clean
bin/magento cache:flush

