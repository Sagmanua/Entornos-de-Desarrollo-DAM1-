# Proyecto: BattleStats — Website de Análisis y Gestión de Datos de Jugadores

## Descripción breve
Sistema web para almacenar datos de jugadores, analizar estadísticas (automática o manualmente), mostrar listados y estados de tanques, y ofrecer estadísticas y recursos de clanes. Incluye un Team Analyzer para analizar equipos de 7–20 jugadores (subida de replays por API o manual), mostrar dos tablas (tanques del equipo y estadísticas agregadas) y detectar si aparecen 3+ jugadores repetidos en distintas replays. Presentado como una especificación lista para implementar.

## Índice
- Objetivo general
- Fase 1 — Análisis (Requerimientos)
  - Requerimientos funcionales
  - Requerimientos no funcionales
  - Herramientas sugeridas
  - Resumen de funcionalidades por página
  - Diseño de la base de datos (ejemplos JSON)
- Fase 2 — Diseño
  - Diseño de la interfaz de usuario (por página)
  - Arquitectura del proyecto (estructura de carpetas)
  - Próximos pasos recomendados
- Apéndices
  - Ejemplos de endpoints/back-end
  - Notas de seguridad y rendimiento

---

## Objetivo general
Crear una aplicación web accesible desde navegador que permita:

- Registrar y almacenar datos de jugadores (manualmente o mediante importación de replays / API).
- Analizar automáticamente o bajo demanda métricas clave (daño promedio, winrate, rendimiento por tanque, etc.).
- Mostrar un catálogo de tanques con filtros y estado (Disponible / Roto / Desbalanceado).
- Gestionar y mostrar estadísticas y recursos de clanes.
- Proveer una página **Team Analyzer** que analice equipos de 7–20 jugadores, procese replays (API o manual), muestre:
  - **Tabla A** — todos los tanques usados por los jugadores del equipo y su estado (roto/no).
  - **Tabla B** — estadísticas agregadas del equipo (daño total/promedio, winrate, MVP, etc.).
  - Detección automática y notificación si 3 o más jugadores aparecen repetidos en distintas replays.

El proyecto debe entregarse como una especificación lista para implementar.

---

# Fase 1 — Análisis (Requerimientos)

### 1. Requerimientos funcionales

#### Página 1: Panel de Análisis de Jugadores — "Player Analyzer"

**Funciones principales**:

* **Ingreso manual de datos**: formulario con campos:
  * Nombre del jugador
  * Batallas
  * Daño total
  * Clan (opcional)

* **Modo automático**: proceso que analiza automáticamente datos subidos (por archivo o API).

* **Cálculos automáticos**:

  * Daño promedio (avg dmg)
  * Partidas ganadas / perdidas (si se dispone de ese dato)
  * Eficiencia total del jugador

* **Visualización**:

  * Mostrar estadísticas analizadas: daño promedio, kill ratio, winrate calculado

#### Página 2: Lista de Tanques — "Tanks List"

**Funciones**:

* Listado de todos los tanques del juego con columnas:

  * Nombre
  * Tipo (Pesado, Medio, Ligero, Artillería)
  * Estado actual (Disponible / Roto / Puede comprar)

* **Filtros**:

  * Por tipo
  * Por estado

* **Admin**: capacidad para marcar rápidamente un tanque como roto o funcional.


#### Página 3: Estadísticas de Clanes — "Clan Stats"

**Funciones**:

* Mostrar lista de clanes con estas columnas:

  * Nombre del clan
  * Cantidad de jugadores
  * Daño promedio del clan

* Botón para ver información detallada de cada clan.

* Opcional: ranking de clanes ordenado por rendimiento y tabla de recursos totales.

#### Página 4: Team Analyzer — Team Analyzer (7–20 jugadores)
**Funciones específicas:**
- Soporta selección de equipos entre 7 y 20 jugadores (detectados automáticamente al importar replays o seleccionados manualmente)
- **Entrada de datos:**
  - Automática: subir replays (uno o varios) o importar desde API
  - Manual: formulario para añadir estadísticas por jugador
- **Análisis automático:**
  - Daño total y promedio del equipo
  - Winrate del equipo sobre las replays importadas
  - Kills/Asistencias promedio por jugador
  - Tanques más usados y uso por jugador
- **Salida visual:**
  - **Tabla A** — Tanques del equipo: Tanque | Tipo | Jugador(es) | Estado (Roto/Disponible) | Veces usado
  - **Tabla B** — Stats del equipo: Daño total, Daño promedio por jugador, Daño máx/mín, Winrate, Tanque más usado, MVP (por daño), Nº replays analizadas
- **Detección de duplicados:**
  - Si se detectan 3 o más jugadores iguales en distintas replays → marcar alerta “Equipo repetido / team fijo”
  - Mostrar partidas donde coinciden esos jugadores
- **Exportar resultados:** CSV/JSON

---

### 2. Requerimientos no funcionales
- Interfaz responsiva (mobile-first)
- Rendimiento: procesar lotes de replays y hasta 20 jugadores sin latencia excesiva (uso de colas o batch si es necesario)
- Escalabilidad: datos inicialmente en JSON para prototipo; migración a SQLite/MySQL recomendada para producción
- Seguridad básica: hashing de contraseñas, roles (admin/analista/usuario), sanitización de entradas
- Integridad y concurrencia: bloqueo al escribir ficheros JSON o uso de DB transaccional
- Limitar tamaño de subida y validar formato de replays

---

### 3. Herramientas sugeridas
- **Frontend:** HTML, CSS (responsive), Python (Fetch API); opcional framework ligero (Vue/React)
- **Backend:** Node.js/Python
- **Base de datos:** JSON para prototipo; SQLite para desarrollo local; MySQL/Postgres para producción
---

### 4. Funcionalidad de cada página 
- **Player Analyzer:** subir/importar datos, ver estadísticas, recalcular
- **Tanks List:** ver/listar tanques, filtros, cambiar estado (admin)
- **Clan Stats:** listar clanes, ver recursos, ranking
- **Team Analyzer:** seleccionar equipo (7–20), analizar replays, mostrar Tabla A (tanques del equipo) y Tabla B (stats agregadas); detección 3+ jugadores repetidos

---

### 5. Diseño de la Base de Datos (ejemplos JSON)

**players.json**
```json
[
  {
    "id": 1,
    "nombre": "PlayerX",
    "batallas": 950,
    "dano_total": 1250000,
    "clan": "WolfPack",
    "tanques_usados": {"IS-7":20000,"Maus":45000},
    "ultima_actualizacion": "2025-11-12"
  }
]
