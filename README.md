
# ERP Neni - Kubernetes

![ERP Neni Logo](https://img.icons8.com/ios/452/erp.png)

**Versión**: 1.0.0  
**Autor**: Gustavo Quintero  
**Licencia**: MIT  
**Construido con**: PHP (Laravel), MySQL, Docker, Kubernetes

---

## 🚀 Visión General

**ERP Neni** es un sistema moderno y modular de **Planificación de Recursos Empresariales (ERP)** diseñado para ayudar a las empresas a agilizar sus operaciones. Esta solución cubre áreas clave del negocio como **gestión de inventarios**, **seguimiento de ventas** y **contabilidad**. Con una interfaz fácil de usar y un backend robusto basado en **Laravel**, este sistema ERP está construido para crecer con las necesidades de tu empresa.

---

## 📦 Características Clave

- **Sistema Modular**: Diferentes módulos para Ventas, Inventarios y Contabilidad.
- **Autenticación de Usuarios**: Roles de administrador, gerente y empleado para un acceso seguro.
- **Gestión de Productos e Inventarios**: Seguimiento de niveles de stock, detalles de productos y más.
- **Ventas y Contabilidad**: Gestión de pedidos de ventas, pagos y registros contables.

---

## 🔧 Tecnologías

- **Backend**: Laravel PHP Framework
- **Frontend**: Blade Templating, HTML, CSS
- **Base de Datos**: MySQL
- **Contenerización**: Docker
- **Orquestación**: Kubernetes
- **Imagen de Docker**: `gustavoquintero/web-image:v5`

---

## 🚢 Arquitectura & Ecosistema

### 🧱 Arquitectura del Sistema

El ecosistema de **ERP Neni** está diseñado para despliegue contenerizado, lo que facilita su escalabilidad y gestión a través de Kubernetes. Así es como funciona el sistema:

1. **Interfaz de Usuario (UI)** - El frontend se aloja en un contenedor Docker ejecutándose en el clúster de Kubernetes.
2. **Backend** - Una aplicación PHP basada en Laravel maneja la lógica de negocio y la autenticación de usuarios.
3. **Base de Datos** - Un contenedor MySQL se utiliza para almacenamiento de datos, inicializado con el script proporcionado `init-db.sql`.
4. **Kubernetes** - Administra y escala tanto la aplicación como la base de datos en producción, asegurando alta disponibilidad y optimización de recursos.

### 🌐 Arquitectura de Kubernetes

```plaintext
  +---------------------+        +--------------------+
  |     Kubernetes      |        |    Motor Docker    |
  |    Cluster Master   |        | (Contenedores en ejecución)|
  +---------------------+        +--------------------+
            |                             |
  +---------------------+        +--------------------+
  |  Servicio de Base   |        |  Aplicación Web    |
  |    (Contenedor MySQL)| <----->|  (Contenedor Laravel)|
  +---------------------+        +--------------------+
            |                             |
       +-------------+               +-------------+
       |  Almacenamiento|             |  Balanceador|
       |   Persistente   |             |     (Opcional) |
       +-------------+               +-------------+
```

Esta arquitectura asegura que el sistema **ERP Neni** pueda manejar un aumento en el tráfico y gestionar los datos de manera eficiente a través de un clúster de Kubernetes.

---

## 🚀 Configuración de Docker & Kubernetes

### 🐳 Docker

Para ejecutar el sistema ERP Neni localmente o en entornos aislados, se utiliza Docker para la contenerización. El proyecto incluye una imagen personalizada de Docker `gustavoquintero/web-image:v5` que contiene todas las dependencias, incluyendo PHP, Composer, Node.js y cliente de MySQL.

- **Aplicación Web**: Alojada en un contenedor ejecutando Laravel PHP.
- **Base de Datos**: Un contenedor MySQL inicializado con `init-db.sql` para configurar la base de datos.

Puedes utilizar la configuración de **Docker Compose** proporcionada para ejecutar todo en contenedores localmente o personalizar los Dockerfiles para diferentes entornos.

### 🧑‍💻 Kubernetes

Para escalabilidad y orquestación en entornos de producción, el sistema **ERP Neni** se despliega usando Kubernetes. A continuación se describen los componentes clave:

1. **Despliegues**: Tanto la **Aplicación Web** como la **Base de Datos MySQL** se definen como despliegues de Kubernetes. Estos despliegues aseguran que los contenedores se gestionen de manera eficiente y puedan escalar según sea necesario.
   
2. **Servicios**: Los servicios de Kubernetes exponen la aplicación al mundo exterior y permiten la comunicación entre los contenedores dentro del clúster.

3. **Almacenamiento Persistente**: Se utilizan volúmenes persistentes para almacenar datos de MySQL, asegurando la persistencia de los datos incluso si los contenedores se reinician o se trasladan a otros nodos.

---

## 📈 Diagramas

### ERP Neni - Arquitectura a Alto Nivel

Este diagrama representa los componentes principales del sistema ERP y cómo se comunican dentro del clúster de Kubernetes.

```plaintext
+--------------------+    +---------------------+    +--------------------+
|   Interfaz de Usuario |<-->|    Laravel PHP      |<-->|      Base de Datos |
|   (Aplicación Web)    |    |   Aplicación        |    |   (Datos Persistentes)|
+--------------------+    +---------------------+    +--------------------+
      |                            |                         |
+-------------+            +-------------+         +------------------+
|  Balanceador  |           | Clúster de   |         |  Volumen Persistente|
|  (Opcional)   |           | Kubernetes   |         |  (Almacenamiento)   |
+-------------+            +-------------+         +------------------+
```

---

## 🛠 Instalación

1. **Clona el repositorio**:
   ```bash
   git clone https://github.com/GustavoQuinteroC/erpNeni.git
   cd erpNeni
   ```

2. **Ejecutar usando Docker**:
   - Construir y ejecutar los contenedores con:
     ```bash
     docker-compose up
     ```

3. **Ejecutar en Kubernetes**:
   - Aplicar las configuraciones de Kubernetes:
     ```bash
     kubectl apply -f k8s/db-deployment.yaml
     kubectl apply -f k8s/web-deployment.yaml
     kubectl apply -f k8s/web-service.yaml
     ```
3.1 **Resultados vistos desde docker desktop**:
![image](https://github.com/user-attachments/assets/9f5dccaf-b0ab-432c-8b0c-a2ded821f75f)
![image](https://github.com/user-attachments/assets/f74a1b64-6cf1-4795-8c5a-a335bca4687d)


4. **Acceder a la Aplicación**:
   - Una vez desplegado, el ERP puede ser accedido a través del servicio web expuesto o mediante el port-forwarding en entornos locales.


5. **Demostracion del proyecto**:
![image](https://github.com/user-attachments/assets/e61ae692-d809-48db-863a-312e456b43e6)
![image](https://github.com/user-attachments/assets/651e0cd4-0f8f-4408-a819-c1837e40ce7f)
![image](https://github.com/user-attachments/assets/d2f4ec94-68e4-41f3-bc17-b7fbdcb5ef94)

---

## 👥 Contribuir

¡Se aceptan contribuciones al proyecto ERP Neni! Para contribuir:

1. Haz un fork del repositorio
2. Crea una nueva rama (`git checkout -b nombre-de-la-caracteristica`)
3. Haz commit de tus cambios (`git commit -am 'Añadir nueva característica'`)
4. Empuja a la rama (`git push origin nombre-de-la-caracteristica`)
5. Crea una nueva Pull Request

Por favor, asegúrate de que tu código esté bien documentado y probado.

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.

---

## 🤝 Agradecimientos

- **Laravel**: Por el robusto framework PHP que alimenta el backend.
- **MySQL**: Por el almacenamiento de datos confiable.
- **Docker**: Por la contenerización.
- **Kubernetes**: Por la orquestación y gestión de contenedores.

---

## 🌟 Mantente Conectado

- **GitHub**: [https://github.com/GustavoQuinteroC/erpNeni](https://github.com/GustavoQuinteroC/erpNeni)
- **Correo Electrónico**: gustavoquintero2000@outlook.com
