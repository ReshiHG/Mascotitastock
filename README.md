# 🐾 Mascotita Stock - Sistema de Gestión Veterinaria

![Status](https://img.shields.io/badge/status-active-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3)

## 📖 Descripción del Proyecto

**Mascotas y Mascotitas** es una aplicación web diseñada para optimizar la gestión del inventario de medicamentos en una clínica veterinaria. Permite a los médicos veterinarios llevar un control preciso de los medicamentos —cantidad restante, unidades disponibles y apartadas—, así como administrar los pedidos a proveedores.

El objetivo principal es **agilizar el servicio, evitar incumplimientos con los clientes y mejorar la organización de los procesos internos**. La aplicación cubre cinco áreas clave:

- **Gestión de usuarios** con roles diferenciados (Jefe de Clínica, Veterinario, Gerente de Inventario/Proveedor, Proveedor y Desarrollador).
- **Actualización y control del inventario** de medicamentos en tiempo real.
- **Administración de categorías** de medicamentos.
- **Alta, baja y edición de proveedores**.
- **Creación, seguimiento y cierre de pedidos** con estados definidos (Pendiente de aprobación, Aprobado, Solicitado, En tránsito, Recibido, Cancelado).

---

## 🚀 Despliegue en Laragon

### Requisitos previos

- **Laragon** instalado (versión completa con Apache/Nginx, MySQL y PHP).
- **PHP 8.0 o superior**.
- **MySQL 8.0 o superior** (el script usa la collation `utf8mb4_0900_ai_ci`).
- Un cliente de base de datos (se recomienda **DBeaver** o **phpMyAdmin**).
- **Git** para clonar el repositorio.

### Pasos para el despliegue

#### 1. Clonar el repositorio

Abre una terminal (Git Bash, PowerShell o la terminal de Laragon) y navega hasta la carpeta `www` de Laragon:

```bash
cd C:\laragon\www
git clone https://github.com/ReshiHG/Mascotitastock.git
```

Esto creará la carpeta Mascotitastock dentro de www.

#### 2. Iniciar los servicios de Laragon

Abre Laragon.

Haz clic en Start All (o Iniciar todo) para levantar Apache/Nginx y MySQL.

Verifica que ambos servicios estén en verde.

#### 3. Crear la base de datos

##### Opción A: Desde DBeaver (recomendado)

    Abre DBeaver y conéctate a tu servidor MySQL local (localhost:3306, usuario root, sin contraseña por defecto en Laragon).

    Abre una nueva pestaña SQL y copia el contenido del archivo Crear_base_de_datos_y_poblarla.sql que se encuentra en la raíz del proyecto.

    Ejecuta el script por bloques para evitar conflictos con el analizador de DBeaver:

        Selecciona y ejecuta CREATE DATABASE ...;

        Luego USE mascotas_y_mascotitas;

        Finalmente, todo el bloque de CREATE TABLE e INSERT.

        Tip: Si el analizador sigue dando errores, cambia la opción "Blank line is statement delimiter" de Always a Smart en Window → Preferences → Editors → SQL Editor → SQL Processing.

##### Opción B: Desde phpMyAdmin

    Accede a http://localhost/phpmyadmin.

    Ve a la pestaña SQL.

    Pega el contenido del script y ejecútalo.

Opción C: Desde la terminal de Laragon
bash

mysql -u root < C:\laragon\www\Mascotitastock\Crear_base_de_datos_y_poblarla.sql

#### 4. Configurar la conexión a la base de datos

Localiza el archivo de configuración de conexión (normalmente en modelos/conexion.php o similar) y verifica los siguientes datos:
php

$host = "localhost";
$user = "root";
$password = "";        // Laragon por defecto no usa contraseña
$database = "mascotas_y_mascotitas";

    Si tu instalación de Laragon tiene contraseña para root, ajústala aquí.

#### 5. Acceder a la aplicación

Abre tu navegador y visita:

http://mascotitastock.test

Si el dominio .test no funciona, verifica que Laragon tenga habilitada la opción "Auto virtual hosts" en Preferences → General. También puedes acceder vía http://localhost/Mascotitastock.

#### 6. Credenciales de prueba

El script de población incluye usuarios de prueba:

  Rol               |   Correo                                | Contraseña  
  Jefe de Clínica       jefa.clinica@mascotasymascotitas.com    123  
  Veterinario           veterinario1@mascotasymascotitas.com    123  
  Gerente de Inventario gerente.inv@mascotasymascotitas.com     123  
  Proveedor             proveedor1@distribuidora.com            123  
  Desarrollador         dev@mascotasymascotitas.com             123  

---

### 🖥️ Descripción de las Ventanas y sus Objetivos

#### 1. 🔐 Inicio de Sesión

Objetivo: Autenticar al usuario antes de permitir el acceso al sistema.

- El usuario ingresa su correo electrónico y contraseña.

- Al hacer clic en "Entrar", el sistema valida las credenciales y redirige a la página de inicio.

- Si las credenciales son incorrectas, se muestra un mensaje de error.

#### 2. 🏠 Página de Inicio

Objetivo: Servir como panel de navegación principal hacia todas las secciones del sistema.

- Presenta botones grandes para cada módulo: Usuarios, Inventario, Gestión de Medicamentos, Gestión de Categorías, Proveedores, Pedidos y Salir.

- También incluye un menú hamburguesa en la esquina superior derecha con las mismas opciones, útil en dispositivos móviles.

- El menú se adapta al rol del usuario (cada rol ve solo las secciones a las que tiene acceso).

#### 3. 👥 Usuarios

Objetivo: Administrar las cuentas de los usuarios del sistema con sus respectivos roles.

- Formulario "Agregar usuario": Permite dar de alta un nuevo usuario seleccionando su rol (Jefe de Clínica, Veterinario, Gerente, Proveedor, Desarrollador) y capturando sus datos generales (nombre, apellidos, email, teléfono, contraseña).

- Sección "Administrar usuarios": Muestra todos los usuarios registrados en tarjetas con sus datos relevantes.

- Cada tarjeta incluye botones Editar (carga los datos en el formulario superior) y Eliminar (pide confirmación antes de borrar).

#### 4. 📦 Inventario

Objetivo: Visualizar y actualizar el stock de medicamentos después de cada consulta veterinaria.

- Muestra tarjetas por medicamento con:
  - Apartados: unidades reservadas para clientes.

  - Stock disponible: unidades libres.

  - Tabletas: cantidad actual por envase abierto.

  - Categorías: a las que pertenece el medicamento.

- El botón Editar permite ajustar los valores de apartado, stock disponible y cantidad restante del envase abierto.

#### 5. 💊 Medicamentos

Objetivo: Gestionar el catálogo completo de medicamentos (alta, modificación y eliminación).

- Formulario "Agregar medicamento": Solicita nombre, imagen de referencia, descripción, stock total, stock apartado, cantidad máxima por envase, cantidad actual por envase, unidad de medida y categoría.

- Sección "Administrar medicamentos": Incluye un buscador por nombre y muestra cada medicamento en una tarjeta con toda su información.

- Botones Editar y Eliminar por medicamento, con confirmación antes de borrar.

#### 6. 🏷️ Categorías

Objetivo: Mantener el catálogo de categorías para clasificar los medicamentos.

- Formulario "Agregar categoría": Nombre de la nueva categoría.

- Sección "Administrar categorías": Lista todas las categorías con botones Editar y Eliminar.

- Al editar, el nombre se carga en el formulario superior para su modificación.

#### 7. 🏢 Proveedores

Objetivo: Administrar los proveedores de medicamentos con los que trabaja la clínica.

- Formulario "Agregar proveedor": Datos generales (nombre, apellidos, email, teléfono).

- Sección "Administrar proveedores": Tarjetas por proveedor con botones Editar y Eliminar.

- Los proveedores se asocian posteriormente a los pedidos.

#### 8. 📋 Pedidos

Objetivo: Llevar el control del ciclo de vida completo de los pedidos a proveedores.

- Formulario "Agregar pedido": Solicita descripción (medicamentos y cantidades), proveedor y fecha de entrega estimada (por defecto, el día siguiente).

- Al crear un pedido, su estado inicial es Solicitado.

- Sección "Administrar pedidos": Muestra cada pedido con:

-     Identificador, estado, proveedor, descripción.

-     Fecha de solicitud, fecha de entrega estimada y fecha de entrega real.

- Al recibir un pedido, se debe Editar, cambiar el estado a Recibido y registrar la fecha de entrega real.

- Los estados disponibles son: Pendiente de aprobación, Aprobado, Solicitado, En tránsito, Recibido, Cancelado.

- Botón Eliminar con confirmación.

---

### 🗄️ Estructura de la Base de Datos

**El sistema se compone de las siguientes tablas:**  

* Tabla Descripción  
* RolUsuario Catálogo de roles del sistema.  
* Usuario Cuentas de acceso con rol asignado.  
* Proveedor Proveedores de medicamentos.  
* Pedido Pedidos realizados a proveedores.  
* EstadoPedido Catálogo de estados del pedido.  
* Medicamento Catálogo de medicamentos con control de stock.  
* Concentracion Concentraciones disponibles (mg, ml, g).  
* UnidadMedida Unidades de medida (tableta, cápsula, frasco, etc.).  
* Categoria Categorías de medicamentos.  
* MedicamentoConcentracion Relación N:M entre medicamentos y concentraciones.  
* MedicamentoCategoria Relación N:M entre medicamentos y categorías.  

![Diagrama Entidad-Relación en formato "Pata de Gallo"](/Diagrama_Entidad_Relación.png)


🛠️ Tecnologías Utilizadas

    PHP (backend y lógica de negocio).

    MySQL 8 (base de datos relacional).

    Bootstrap 5 (diseño responsivo).

    HTML5 / CSS3 / JavaScript (interfaz de usuario).

    Laragon (entorno de desarrollo local).

    Git (control de versiones).

📝 Notas Adicionales

Las contraseñas de los usuarios de prueba son 123 y están almacenadas en texto plano con fines demostrativos. En producción deben almacenarse con password_hash() de PHP (bcrypt).

El archivo EJEMPLO.SQL contiene una consulta de referencia con un error tipográfico: usa P.EstadoPedido en lugar de P.IDEstadoPedido. Corrígelo si lo reutilizas.

El script de base de datos debe ejecutarse en bloques si se usa DBeaver, para evitar conflictos con su analizador SQL.

El repositorio oficial del proyecto es: https://github.com/ReshiHG/Mascotitastock

📄 Licencia

Proyecto desarrollado para la gestión interna para la clínica veterinaria Mascotas y Mascotitas. Todos los derechos reservados.
