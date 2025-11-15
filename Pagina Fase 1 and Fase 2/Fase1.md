# Proyecto: BattleStats — Website de Análisis y Gestión de Datos de Jugadores

> **Descripción breve**: Sistema web para almacenar datos de jugadores, analizar estadísticas (automática o manualmente), mostrar listados y estados de tanques, y ofrecer estadísticas y recursos de clanes. Presentado como un proyecto profesional, claro y listo para continuar con la implementación.

---

## Índice

1. [Objetivo general](#objetivo-general)
2. [Fase 1 — Análisis (Requerimientos)](#fase-1---análisis-requerimientos)

   * Requerimientos funcionales
   * Requerimientos no funcionales
   * Herramientas sugeridas
   * Resumen de funcionalidades por página
   * Diseño de la base de datos (ejemplos JSON)
3. [Fase 2 — Diseño](#fase-2---diseño)

   * Diseño de la interfaz de usuario (por página)
   * Arquitectura del proyecto (estructura de carpetas)
4. [Próximos pasos recomendados](#próximos-pasos-recomendados)
5. [Apéndices]

   * Ejemplos de endpoints/back-end
   * Notas de seguridad y rendimiento

---

## Objetivo general

Crear una aplicación web accesible desde navegador que permita:

* Registrar y almacenar datos de jugadores.
* Analizar automáticamente o bajo demanda métricas clave (daño promedio, winrate, rendimiento por tanque, etc.).
* Mostrar un catálogo de tanques con filtros y estado (disponible / roto / desbalanceado).
* Gestionar y mostrar estadísticas y recursos de clanes.

El proyecto debe entregarse como una especificación lista para implementar.

---

## Fase 1 - Análisis (Requerimientos)

### 1. Requerimientos funcionales

#### Página 1: Panel de Análisis de Jugadores — "Player Analyzer"

**Funciones principales**:

* **Ingreso manual de datos**: formulario con campos:

  * Nombre del jugador
  * Batallas
  * Daño total
  * Barcos/tanques usados (mapa tanque → daño o daño medio)
  * Fechas (registro / rango de análisis)
  * Clan (opcional)

* **Modo automático**: proceso que analiza automáticamente datos subidos (por archivo o API).

* **Cálculos automáticos**:

  * Daño promedio (avg dmg)
  * Daño por tanque
  * Partidas ganadas / perdidas (si se dispone de ese dato)
  * Eficiencia total del jugador

* **Visualización**:

  * Mostrar estadísticas analizadas: daño promedio, kill ratio, winrate calculado, rendimiento por tanque.
  * Gráficas (opcional): daño por tanque, evolución temporal.

#### Página 2: Lista de Tanques — "Tanks List"

**Funciones**:

* Listado de todos los tanques del juego con columnas:

  * Nombre
  * Tipo (Pesado, Medio, Ligero, Artillería)
  * Estado actual (Disponible / Roto / Desbalanceado)

* **Filtros**:

  * Por tipo
  * Por estado

* **Admin**: capacidad para marcar rápidamente un tanque como roto o funcional.

* **Ejemplo (tabla)**:

| Tanque | Tipo   | Estado     |
| ------ | ------ | ---------- |
| T-34   | Medio  | Disponible |
| Maus   | Pesado | Roto       |

#### Página 3: Estadísticas de Clanes — "Clan Stats"

**Funciones**:

* Mostrar lista de clanes con estas columnas:

  * Nombre del clan
  * Cantidad de jugadores
  * Daño promedio del clan
  * Recursos del clan (Oro, Combustible, Materiales, Créditos)

* Botón para ver información detallada de cada clan.

* Opcional: ranking de clanes ordenado por rendimiento y tabla de recursos totales.

### 2. Requerimientos no funcionales

* Accesible desde navegador (responsivo / mobile-first).
* Interfaz clara, usable y consistente.
* Optimizada para móviles.
* Capacidad de manejo de grandes listados (paginación, lazy-loading).
* Lectura/escritura rápida en formato JSON o SQLite.
* Seguridad básica: validación de entradas, sanitización y control de integridad para evitar datos corruptos.

### 3. Herramientas sugeridas

* **Frontend:** HTML, CSS, JavaScript (vanilla o framework ligero).
* **Backend:** PHP (responsable del análisis automático y endpoints para lectura/escritura), aunque puede adaptarse a Node.js/Python según preferencia.
* **Base de datos:** JSON (para prototipo) o SQLite (ligero, escalable localmente).

### 4. Funcionalidad de cada página (resumen)

* **Player Analyzer (Página 1)**

  * Subir datos del jugador (manual o archivo).
  * Ver estadísticas generadas automáticamente.
  * Opción de cálculo manual.
  * Gráficas y tabla de estadísticas.

* **Tanks List (Página 2)**

  * Listado completo de tanques.
  * Filtro por tipo y estado.
  * Paginación.
  * Admin: cambiar estado de tanque.

* **Clan Stats (Página 3)**

  * Listado de clanes.
  * Ver estadísticas y recursos.
  * Ranking opcional.

### 5. Diseño de la Base de Datos (ejemplos JSON)

**players.json**

```json
[
  {
    "id": 1,
    "nombre": "PlayerX",
    "batallas": 950,
    "dano_total": 1250000,
    "klan": "WolfPack",
    "tanques_usados": {
      "T-34": 20000,
      "Maus": 45000
    }
  }
]
```

**tanks.json**

```json
[
  {
    "id": 101,
    "nombre": "T-34",
    "tipo": "Medio",
    "estado": "Disponible"
  }
]
```

**clans.json**

```json
[
  {
    "id": 10,
    "nombre": "WolfPack",
    "jugadores": 40,
    "dano_promedio": 1800,
    "recursos": {
      "oro": 5000,
      "materiales": 8000,
      "combustible": 3200,
      "creditos": 2000000
    }
  }
]
```

---

## Fase 2 - Diseño

### 1. Diseño de la Interfaz de Usuario

#### Página 1 — Panel de Análisis del Jugador

**Componentes**:

* Título: *Analizador de Jugadores*
* Sección 1: Ingresar datos manualmente (formulario)
* Sección 2: Subir archivo de datos (CSV/JSON)
* Sección 3: Resultados del análisis (gráfica de daño + tabla de estadísticas)
* Controles: botón para recalcular manualmente, selector de rango temporal.

#### Página 2 — Lista de Tanques

**Componentes**:

* Buscador (por nombre)
* Filtros: tipo, estado
* Visualización: tarjetas o tabla (20 por página)
* Botón admin: “Marcar como roto / disponible”

#### Página 3 — Estadísticas de Clanes

**Componentes**:

* Tabla de clanes con columnas (Nombre / Jugadores / Daño promedio / Recursos totales)
* Botón "Ver clan" para detalles
* Gráfica opcional: ranking por daño promedio

### 2. Arquitectura del proyecto (estructura sugerida)

```
/frontend
   index.html
   player_stats.html
   tanks.html
   clans.html
   styles.css

/backend
   analyze_player.php
   load_players.php
   load_tanks.php
   save_tank_state.php
   load_clans.php

/database
   players.json
   tanks.json
   clans.json
```

---

## Próximos pasos recomendados

1. **Definir API**: endpoints REST y contratos de datos (exponer JSON con campos y formatos).
2. **Prototipo UI**: crear maqueta rápida (Figma/HTML estático) con los tres flujos principales.
3. **Implementación inicial**:

   * Backend: endpoints `load_*` y `save_tank_state.php` + análisis `analyze_player.php`.
   * Frontend: formularios y tablas con paginación.
4. **Pruebas**: unitarias y de integración con dataset de ejemplo.
5. **Optimización**: migrar a SQLite si los volúmenes aumentan.

## Apéndices

### Ejemplo de endpoints (sugeridos)

* `GET /api/players` — listar jugadores (paginado)
* `POST /api/players` — crear/actualizar jugador
* `POST /api/players/analyze` — subir datos y desencadenar análisis
* `GET /api/tanks` — listar tanques (filtros por query)
* `POST /api/tanks/{id}/state` — actualizar estado (admin)
* `GET /api/clans` — listar clanes
* `GET /api/clans/{id}` — detalle clan

### Notas de seguridad y rendimiento

* Validar y sanitizar todas las entradas del usuario.
* Control de concurrencia al escribir en ficheros JSON (lock file o migrar a SQLite).
* Limitar tamaño de subida y paginar respuestas.
* Implementar CORS y autenticación básica para endpoints de administración.

---

*Documento generado: Especificación técnica y de diseño para las fases 1 y 2 del proyecto "BattleStats". Listo para compartir con el equipo de desarrollo.*
