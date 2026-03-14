# Wiki del Proyecto - Sistema de Gestión Documental y PQRS (Gedocs)

Este documento sirve como guía detallada sobre el funcionamiento, las reglas de negocio y las características implementadas en el sistema Gedocs.

---

## 🚀 Visión General
Gedocs es una plataforma integral para la gestión documental y el trámite de PQRS (Peticiones, Quejas, Reclamos y Sugerencias), diseñada específicamente para centros de formación (SENA). Permite la trazabilidad completa de documentos, desde su entrada hasta su respuesta oficial.

---

## 🔢 Sistema de Radicación
El sistema utiliza una numeración consecutiva para garantizar la integridad y el orden cronológico de los documentos.

- **Formato de Radicado**:
  - `RE-XXXX.X`: Para radicados de **Entrada**.
  - `ENV-XXXX.X`: Para radicados de **Salida**.
- **Regla del 0.1**: Los consecutivos no comienzan en 1, sino en **0.1** (ej. `RE-0000.1`). Esto permite una sub-organización flexible según los requerimientos administrativos del centro.
- **Generación Automática**: El sistema asigna el siguiente número disponible de forma automática al crear una PQR o generar una comunicación oficial.

---

## 📥 Gestión de PQRS
Existen dos tipos principales de documentos en la bandeja de entrada:

### 1. Documentos de Entrada (RE)
- Provienen del formulario público o registros externos.
- **Seguridad**: Por integridad legal, el contenido de estos documentos (emisor, descripción, asunto) **no se puede editar** una vez registrado.
- **Acciones permitidas**: Responder, archivar y cambiar estado.

### 2. Documentos de Salida (ENV)
- Son respuestas o comunicaciones oficiales producidas internamente.
- **Edición**: Pueden ser editados por el personal autorizado para realizar correcciones antes de su cierre definitivo.
- **Trazabilidad**: Cada salida genera automáticamente un registro en la bandeja para seguimiento.

---

## 📂 Organización del Archivo (Estructura Jerárquica)
El sistema impone una estructura de carpetas estricta para cumplir con las normas de gestión documental:

1. **Ficha / Sección**
2. **Año**
3. **Dependencia**
4. **Serie**
5. **Subserie**

### 🔒 Bloqueo Anual de Archivos
Para evitar alteraciones en años contables/administrativos cerrados:
- Se prohíbe la subida de nuevos archivos a carpetas cuyo nivel de "Año" sea anterior al año actual.
- **Excepción**: Se permite continuar con el trámite y respuesta de PQRS iniciadas en años anteriores para garantizar la continuidad del servicio.

---

## 📄 Generación de Comunicaciones Oficiales (PDF)
El generador de PDF permite crear documentos con validez institucional.

- **Tipos de Documentos**: Acta, Informe, Circular, Comunicación Oficial, y la opción **OTRO** para flexibilidad total.
- **Elementos de la Plantilla**:
  - Logo oficial institucional.
  - Encabezados dinámicos por dependencia.
  - Espacio para firma electrónica/placeholder.
  - Pie de página con información de contacto del centro.
- **Asignación de Consecutivo**: Al "Generar PDF", el sistema consume automáticamente un radicado de salida (`ENV`).

---

## 🔍 Filtros y Búsqueda
La bandeja de entrada y la sección de carpetas incluyen filtros avanzados para una localización rápida:

- **Buscador General**: Permite buscar por asunto, descripción, nombre del emisor, destinatario o número de radicado completo.
- **Filtro por Año**: Localiza rápidamente documentos de gestiones pasadas.
- **Filtro por Tipo**: Alterna entre ver solo entradas, solo salidas o todas las comunicaciones.
- **Filtro por Radicado**: Búsqueda exacta para auditorías.

---

## 👥 Roles y Permisos
- **Administrador**: Control total sobre usuarios, fichas, dependencias y edición de cualquier documento.
- **Instructor**: Gestión de aprendices y PQRS relacionadas con sus fichas técnicas asignadas.
- **Dependencia**: Gestión documental y respuesta a comunicaciones dirigidas a su área específica.
- **Aprendiz**: Radicación de PQRS y seguimiento de sus propias solicitudes.

---

*Última actualización: Marzo 2026*
