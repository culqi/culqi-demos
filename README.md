# PHP Demo Custom Checkout

## Descripción del Proyecto

Este proyecto es una demostración de un sistema de checkout personalizado desarrollado en PHP. Incluye funcionalidades para gestionar productos, un carrito de compras y un proceso de pago. El proyecto utiliza varias tecnologías y patrones de diseño para asegurar una arquitectura limpia y mantenible.

## Tecnologías Utilizadas

- **PHP**: Lenguaje de programación principal.
- **Filebase**: Sistema de base de datos basado en archivos.
- **Composer**: Gestor de dependencias para PHP.
- **PSR-4**: Estándar de autoloading para PHP.
- **MVC**: Patrón de diseño Modelo-Vista-Controlador.

## Estructura del Proyecto

- **app/**: Contiene los controladores, modelos, servicios y proveedores.
- **public/**: Carpeta pública que contiene el archivo `index.php`.
- **storage/**: Carpeta para almacenamiento de datos.
- **vendor/**: Carpeta de dependencias gestionadas por Composer.
- **bootstrap/**: Configuración inicial y registro de dependencias.
- **routes/**: Definición de rutas del proyecto.

## Cómo Funciona

1. **Controladores**: Gestionan las solicitudes HTTP y coordinan las respuestas.
2. **Modelos**: Representan los datos y la lógica de negocio.
3. **Vistas**: Plantillas que renderizan la salida HTML.
4. **Servicios**: Contienen la lógica de negocio reutilizable.
5. **Proveedores**: Gestionan la configuración y la inicialización de servicios externos.

## Cómo Levantar el Proyecto

### Requisitos Previos

- **PHP** >= 7.4
- **Composer** instalado

### Pasos para Levantar el Proyecto

1. **Clonar el repositorio**:

```bash
git clone https://github.com/tu-usuario/php-demo-custom-checkout.git
cd php-demo-custom-checkout
```

2. **Instalar dependencias**:

```bash
composer install
```

3. **Configurar el entorno**:

- Asegúrate de que la carpeta `products` exista y tenga permisos de escritura.

4. **Agregar datos dummy**:

- Ejecuta los scripts desde la carpeta scripts para agregar datos dummy:

```bash
php scripts/{{add_dummy_data}}.php
```

5. **Levantar el servidor**:

```bash
php -S localhost:8000 -t public
```

6. **Acceder a la aplicación**:

- Abre tu navegador y ve a `http://localhost:8000`.

## Contribuciones

- Dennis Villagaray

## Licencia

Este proyecto está licenciado bajo la `Licencia MIT`. Consulta el archivo LICENSE para más detalles.
