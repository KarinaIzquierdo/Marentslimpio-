-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-05-2026 a las 22:59:16
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Marents_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(9, 'Hombre', NULL, NULL),
(10, 'mujer', NULL, NULL),
(11, 'Niños', NULL, NULL),
(12, 'Pisa huevos', NULL, NULL),
(13, 'Outlet', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id`, `nombre`, `hex`) VALUES
(1, 'Negro', NULL),
(2, 'Blanco', NULL),
(3, 'Rojo', NULL),
(4, 'Azul', NULL),
(5, 'Café', NULL),
(6, 'Negro', '#000000'),
(7, 'Blanco', '#FFFFFF'),
(8, 'Azul', '#1D4ED8'),
(9, 'Rojo', '#DC2626'),
(10, 'Gris', '#6B7280'),
(11, 'Marrón', '#8B4513'),
(12, 'Beige', '#F5F5DC'),
(13, 'Rosado', '#EC4899'),
(14, 'Naranja', '#F97316'),
(15, 'Morado', '#7C3AED'),
(16, 'Verde oliva', '#556B2F'),
(17, 'Verde claro', '#22C55E'),
(18, 'Azul claro', '#38BDF8'),
(19, 'Gris claro', '#D1D5DB'),
(20, 'Dorado', '#D4AF37'),
(21, 'Plateado', '#C0C0C0'),
(22, 'Vino tinto', '#7F1D1D'),
(23, 'Camel', '#C19A6B'),
(24, 'Nude', '#E5C1A7'),
(25, 'Terracota', '#E2725B'),
(26, 'Chocolate', '#5C4033');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2020_01_01_000000_create_base_marents_tables', 1),
(5, '2026_03_18_191428_update_users_table', 1),
(6, '2026_03_18_191724_add_rol_to_users_table', 1),
(7, '2026_05_06_192849_create_cart_items_table', 1),
(8, '2026_05_19_133017_create_cart_system_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `categoria_id`, `created_at`, `updated_at`) VALUES
(15, 'Runline', 9, NULL, NULL),
(16, 'UrbanFlow', 10, NULL, NULL),
(17, 'Zootopia', 10, NULL, NULL),
(18, 'Zootopia', 11, NULL, NULL),
(19, 'prueba', 10, NULL, NULL),
(20, 'Elegant', 10, NULL, NULL),
(21, 'Mafalda', 12, NULL, NULL),
(22, 'prueba', 13, NULL, NULL),
(23, 'outlet', 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modelo_id` bigint(20) UNSIGNED NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'activo',
  `tallas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tallas`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `modelo_id`, `estado`, `tallas`, `created_at`, `updated_at`) VALUES
(14, 18, 'activo', NULL, NULL, NULL),
(15, 15, 'activo', NULL, NULL, NULL),
(16, 20, 'activo', NULL, NULL, NULL),
(17, 21, 'activo', NULL, NULL, NULL),
(19, 23, 'activo', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagens`
--

CREATE TABLE `producto_imagens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_imagens`
--

INSERT INTO `producto_imagens` (`id`, `producto_id`, `url`, `created_at`, `updated_at`) VALUES
(14, 14, 'storage/productos/1779216798_temp_image_1779216798057.jpg', NULL, NULL),
(15, 15, 'storage/productos/1779219381_temp_image_1779219380278.jpg', NULL, NULL),
(16, 16, 'storage/productos/1779219416_temp_image_1779219415653.jpg', NULL, NULL),
(17, 17, 'storage/productos/1779736175_temp_image.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_personalizacion`
--

CREATE TABLE `producto_personalizacion` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `permite_nombre` tinyint(1) DEFAULT 0,
  `permite_texto` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_variacion`
--

CREATE TABLE `producto_variacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `talla_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `color_secundario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `costo` decimal(12,2) NOT NULL DEFAULT 0.00,
  `precio` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `tiene_descuento` tinyint(1) NOT NULL DEFAULT 0,
  `valor_descuento` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0U09S9QeyhAg7m4ffmUgmmOfVsY7IUj5wwXYi8dH', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJQek9XOFJpMWRvTWJibXVuZmxGNlRyT2ZVMFpPbnpUMnhENVlGcnlqIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806226),
('1DqsGpsWHbPagfFkG2DKNCvPLtaERGNzxZ6cL3Ke', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJ3RVI3ekkySDRyZTNnMHRveElSejc5cTF3S1RwbkJJWm1aWnc3R0ViIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806221),
('1RClmiIPDpWbEZYRBIVgw4UiwZ2YI4VtzP13bNvE', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJxUUVpT2tXZlFaOTU5Uk1jN2IzblI2SzJzdVgyMHAwd0dCZ2lIT2VHIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725669),
('2vay40NVOidH03fkCA99gFStujsLqAz20EX2LRLz', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJoSE04aW8yaDh6NnRxMEZIa1NIRmtYdkNYVTM4M0prb2d2OUVnQUgzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806225),
('3mIi2joUdd9BKViTcJq0ZjGnVO15otIQTTKoneyv', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuNWk2dHdjUjlxdGloVW9xU0xMaENyaW9YaTF3eWxhYUdLc1Y3dGZrIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1779819947),
('4wFwfVkG2hbYvLprNWoX71MmIto2ZKjO5R9yO63l', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJIMVhVczhKVU1GZXFzMkxMc1lWeUtBbUhIVlI1bnI0NzBaemQ1MlFqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9jYXRlZ29yaWFcL2NhYmFsbGVybyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779973669),
('5MJQO8DuffpIuo6qz1sCFr4K5KffBRld2lyDXOCW', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJSNW51bzFacEtMQnhkRjdWTEk4SXJ1WGVvbXZwZ2Q3bVNmc3FRN3JzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725941),
('9DpCXXawyYgnAc2pyacLkjmiD0GGIpqrQRKllhBT', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiI0TzlaeTR6WFVtVGVBYjN0MEhSMkdBY1JzUnh1TTZLT1pySWdKYjRqIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779984910),
('AFFjyE2sYjp66CMtHvAVofm9SPnBi89PeJEtmmVS', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJSaGFoUnRBMU14VUZFZG5LUGcyUXlIbUdjbHZhZE44VGE1dWdXblpNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725658),
('dWQQC84u5VHBdrgmmzVuBBVnIBvQN0whskSv5Yfs', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJVRFVFazFpSTVscEFianViNnM0aThpWWUwSFVobGFWZGFpOVJGZXVPIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806250),
('DzCTMCsSot1w2WWGxMdzA5HcQ6mSbdj8Ldbm4RJ9', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJWVUFwWHdCQUFBeFBYQ1l3S21aTVBBMndZUWQwbXo5WHZCUHdFbEYwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806229),
('EtdQ7q6fr4G3hmpH40ujv49o3PUeBX76GvWXEmZg', 4, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJIaGJEWnRmQnlXYXhjVkVOUXNCNGUzdEpnOXdjOTRrTmNUSVp4NUROIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9jYXRlZ29yaWFcL2RhbWEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjR9', 1779721065),
('Fx7NYJFIowfP84t8w0kiM1jdkTMrccibOWnduuLl', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJRSW9CSE5udUt4V3N0SnQ2Sk11M2Z0czBPbWRyRkR1MjhGYmIzd1NzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725930),
('Gm6m4IqqWSPgzYC5PyBWaQdwe1aS2rnEMmRGNh82', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJ2MWRTWjZoME1jcXVKbzlhV0RYeWtWaFZkSUpTa01FbmdJZ0RBMHoxIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806258),
('HgqgoXMvJttR77f7sscBaMufAgn2HrKaMRW0C1ru', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiJOVDdRVG95c0ZHNDRiNHY3NzFsbWxkMUwxTHI5bG9hYkN1UXlKNEpNIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725374),
('IChoepUzCh47fpRg5YNrVrY4mXRbVsQ2ABLWPghY', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJGR2lkRnpjZ3NIejdETlhIdE4zc1hFMHV4T0R3OFY2SDhGdWdMUDdQIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806225),
('J5Nz9zR30amiK2bpYtC4ooPImigz0UbDSQ3e97Lp', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJwQzBTekhMU1dtajBvenBpa3pnWnFRM3dSd0cxRVRtM1ZxSUdqT0dNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzAuMC4wLjA6ODAwMCIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779802703),
('jrSlRgSI2xYR1TOKQFHQUfb3t4MYkE0mB74sdygh', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJPY3F4VHk1eGRxU3RUWU9EemV4UXJDRnl3eXNrTkhBQm82dmxpUmdLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9jYXRlZ29yaWFcL2JvdGFzIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1780004075),
('jV3tBq3r1U6zO4NgpdDqQHOb0CfezkSgQZqIauoe', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiJOOWhtSjFLeDBxQVg4dkZHR2lQNXRuZVkwYVhsREdyVE9EWFJXMU13IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779979124),
('kaPYw9MG755jMypGttuhUmU4q1gXOurWg7L227A9', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiI5ZkNHWWxGTTJmYXVEMnAwaFQ4S1R5Y3Zha1ZVOU1rMTQ4a3JvaTNwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806228),
('kGFsImKNpUodVCpnLP2s3W3scAviBRSa8Iyk1ZL3', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJHY3VzWTNmbEtQYW9pR0wwOVhmdDJFRnZ3YzBKZ0Ztc3RJNUVzdHlNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725911),
('KLRlw2MEzKGJWbYy6d6v6G2NWdFMqXuyEVNvlhpz', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJtVVczVXIxNGozTFVuR1hkOGpjQlI0U3BlRDhFZmlMa1k2YXJSRW5IIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806223),
('kxhUUIUxvBABntQGuL5rHYW75pFg20N2cau50CrL', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJnT2ZvQkJvdG1qeTZYUG9pUnVQbUxBeGh6TkE1QmphYVIwWVQ2YjBZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806226),
('m9peYtocsemIq36TE36JQGyO7YutbLzrHNXbH0m1', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJVUzkzVDFyOVdJako0a0w4WU13OGVZMzk1U2pHT0h4WWlTRUxpMFBGIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779744872),
('McNnEFadvxuTII28M1TTOSvSn2KFFjTqA2TvdThV', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJJUGw3dGx4eU9hZUtZSjV3Tk5idlpoS09LSW05U09jcDRqaTVsZWJiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTkiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725572),
('MD58ADJGqZSICP3dUXMTuaBZBz0smr5Bh6xfDcbB', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJoeTVKbjB6VDFSd2RaWlRIVHh0eG5lUlNNTTZPYkRaOHFQN1ppTDJYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1779282593),
('mFkhRCaCWQGDW0I8mxgXyckNGkU4EzqV0svUpvQ3', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJrZmg5U1NsYzJjTTdBcVE5bmZWU2EweFlrbWdoRG1oWFlTMlI1Vm54IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806228),
('Mj4tdXW1WRMV6pMFZp39XCG0BA03cu4HGYuKvVuL', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkUHFOOE5MVWRpVkZISWJuM3ljR29CNXJPZmRXVWpaUDZjZ0JCZGg2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9jYXRlZ29yaWFcL25pbm9zIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1779208326),
('N8eG1YKF7fLTJfHtqKLh8d4Ip5AzYZx35EKmHttD', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJuckRmZWlVaUNaT24zU0tJWkljdDBiRjAza28xUHprMzd1Y3J6anVrIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779744856),
('NAg03wlL1XYURC405KiQzd5wavPrXsYGlNtq9Q5A', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJmdjQxbHZMR042c0QzZld3cnpYOEpZN21pdUkya3QzSjVNY3VJUjB5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1780063611),
('NDjDG98oKlQ65qVyK3vBGU2dljL2JYW78la23jfn', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuWmVRZTR3RGYxdUhEcTF4cHlxREUyVmE5NGpCVnBJTmtxUU15NjQzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1779304686),
('OgqEcj4yr1onxjqvdQcJPbFlAr8ZYGTsM4LchfaE', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJ5NkZjQVJ0bXBMYkc5TkxEckNkZXFqdkRCdTNoSTUyZFM5bkRnR1dYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725944),
('ONbyoJNK3ziMPIS6ewyhFMc5dQaHKEsdq9oDwdpQ', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiIwbUNHWW5oM2c5Z0Q5ZDJIdHRjcllacldoY2owZjhGdzh4RTlEMVA2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806227),
('oRm9TcJxAA4ETfwPoT8txgJgX9wx9HbLCDVnYjU3', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJXbXV0Wk13aFJhU2dEank3S290eE85WWJadEFvMW5qbFNlaFhzYW5KIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725671),
('pOdD3REEpyj5LdFKkAyBVsJtBs65sWkXuH6bQYGo', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiIxdmh1cnZxRVRod2drb1h1V0NZd3FETDNYRmtva201UTZreGgzSkp5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779724098),
('pzO6oyv4vZyw2RHeJxiIa8BGdydd3stPSk0NqSCP', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJJZWliblJndzRwQWlMODdEdmk1azhYeU4wakFVMGt3SFV5azl1eFZqIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxXC9jYXRlZ29yaWFcL2NhYmFsbGVybyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779828695),
('qscjt2TZjK7QMi8wdgJhzPvfthIXl4mSzDxqJyXs', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJQampkZ244Z2pwM2REck5uUFhIRGI3aUF0anVPdW84MlFQWGZBaklvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806229),
('rkEKBS9nKjGzdfHS7qtObXAWlyLj4nTywrR9k4O4', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJBd0czZzAwM0lEdm5hT0Fya1BsalRWTms0QW9PSHpOaUN6S1VnOWZ1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725662),
('sz5XzD25msGbRy29EdYNDlHqunVEfEw6FRlyQuCb', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJva3VxRWswV3NSMGNycVlDOG1sM0hzRnZsRDRxbVc4WjN4QmpwWmJsIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779806227),
('T3ovlEqow4vugM0Su0l1dnDPsTbFOUnMhQbOmc6U', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJ6RVY5QU92UTIxY1lkZzlYWDRYVDBjeUJBbm9oQTl3VUh2aENRenhGIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725654),
('u5jQHUW6X0djzvMHzkqMK6dekVkYE3qm7mL1lpBj', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjMUhDYXAyNXdIT1BVZGtiOWx0ZXoxSXNvOWlGakJ4em1YYzBlWFczIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1779800935),
('ueyRezAWiMKXthUFVTmgZrx82Ny3214kAtqxlvQs', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJKV0RZajRTREt1OWFaQUtINk5FUzE0SUlNRHBaMjZSVzh5MGRGOWtJIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725928),
('uGGo8CVF9sa2U6VKg74sY4Q5zzh5BFsr0XkkYf63', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiJpUTVPVEpFMkxPYURoRU11QUZVZWFBV0I5OVJHcnBGYVczUWVNVWc3IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725319),
('Up6xsaeKnZV48CCn0brAZvSFXT3KkWF6zrSvbVVR', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJkZmNzZEo5V3piYkNtcWRpUzFkcEpQc0MzeTBkb1lHdkdsODRnN2VzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779744863),
('vbN3Xro9d4qsP7faNFM1I5PdRYlqbvNowFaYnMbp', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiI2YlFLWjBaREd3Y2t6dnpVTUVSNFp5dlkxeU91T29ydmFHNDFxbkF0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725662),
('WnnXDq4skQfH7gCEslJEwbvuM8ZrQl0riteY6WWm', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI2dnlLckpaWE00S0puQTBNakl5SDNHR2d0OXU5Q1hSS3Nmd2dudHNhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzAuMC4wLjA6ODAwMSIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779721546),
('X7Rj3apFLIwWGqS4Q0KqBzHB3r9O8rVgUDjQluY8', NULL, '127.0.0.1', 'curl/8.7.1', 'eyJfdG9rZW4iOiJIaE01dGE5U21TWGEyeHp1b01wS1N3bGJ5Nk1Sa2hLSmJNQm1Fck9TIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779982340),
('xLqxWxGDoCEtLG38KOAJuyWfjFDIlC6z4w6zLjWp', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJYM1cxaTBFb2NLdjFVa1BSVjY1Z1RXRUVPYXo3ZXBqd3lOcjVrM1htIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779806250),
('XTcJQ9QMgvAqd1GYNYgz1CeHgLEzd3OHpFUDZNhC', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJvV3J2UzdmclY2SUFTT1Q2S1QzS0JSWVVtbG5Fb3RkNmFLMDZ1M2NWIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1779725569),
('YsBb9YfkUoBYTRZxovUqpWCnbngdpJj3cs5Iodru', NULL, '127.0.0.1', 'okhttp/4.11.0', 'eyJfdG9rZW4iOiJidmJoVjZXTnZmUGxWeHlwbjRueHlIS3lzbkVVTXNOMW5tWmUycndwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEwLjAuMi4yOjgwMDFcL2FwaVwvY2FydD91c2VyX2lkPTEiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1779725921);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talla`
--

CREATE TABLE `talla` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talla`
--

INSERT INTO `talla` (`id`, `numero`) VALUES
(1, 21),
(2, 22),
(3, 23),
(4, 24),
(5, 25),
(6, 26),
(7, 27),
(8, 28),
(9, 29),
(10, 30),
(11, 31),
(12, 32),
(13, 33),
(14, 34),
(15, 35),
(16, 36),
(17, 37),
(18, 38),
(19, 39),
(20, 40),
(21, 41),
(22, 42),
(23, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombres`, `apellidos`, `documento`, `celular`, `email`, `email_verified_at`, `password`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Marents', '12345678', '3000000000', 'admin@marents.com', NULL, '$2y$12$qHBVoVTyYIpkszaMQ8zCTOW/n3e5ukADX4k/pNmWJ7H1yJkYTLd.S', 'admin', NULL, '2026-05-19 18:41:14', '2026-05-26 18:25:23'),
(3, 'Laura', 'Izquierdo', '1109382414', '3143358857', 'ortizizquierdolaurakaria@gmail.com', NULL, '$2y$12$gD1Fy8Sl5qBx8zY85aMKvOkkYups3UlA24pGOPKOhbhZC7GZI857G', 'cliente', NULL, '2026-05-20 00:39:17', '2026-05-26 19:24:09'),
(8, 'Nicolas', 'Bautista', '1109382679', '3143358856', 'nicolas@gmail.com', NULL, '$2y$12$ulAWYmJM/LDIstBbo0ENvu4FnNKr4tXKS6XYIAahW3f/8x9OVgLwe', 'cliente', NULL, '2026-05-28 23:45:26', '2026-05-28 23:45:26'),
(9, 'Angelica', 'Izquierdo', '1109382670', '3125315330', 'angie@marents.com', NULL, '$2y$12$p/zUwWdx7kPAyVKgLkrBiOVAkl3DPqOASTrdNpbWMst1xVGby4IHW', 'cliente', NULL, '2026-05-29 18:39:09', '2026-05-29 18:39:09'),
(10, 'Nicole', 'pilco', '1109382769', '3143388745', 'nicole@gmail.com', NULL, '$2y$12$9Bjq0hPaFfHMsz.91VKrvOjlG3O3n5XNQ626ibQ5OOXNM6h3mZ0bi', 'cliente', NULL, '2026-05-29 18:52:23', '2026-05-29 18:52:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrito_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modelos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_modelo_id_foreign` (`modelo_id`);

--
-- Indices de la tabla `producto_imagens`
--
ALTER TABLE `producto_imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_imagens_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `producto_personalizacion`
--
ALTER TABLE `producto_personalizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `producto_variacion`
--
ALTER TABLE `producto_variacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_variacions_producto_id_foreign` (`producto_id`),
  ADD KEY `producto_variacions_talla_id_foreign` (`talla_id`),
  ADD KEY `producto_variacions_color_id_foreign` (`color_id`),
  ADD KEY `producto_variacions_color_secundario_id_foreign` (`color_secundario_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `producto_imagens`
--
ALTER TABLE `producto_imagens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto_variacion`
--
ALTER TABLE `producto_variacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_modelo_id_foreign` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_imagens`
--
ALTER TABLE `producto_imagens`
  ADD CONSTRAINT `producto_imagens_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_variacion`
--
ALTER TABLE `producto_variacion`
  ADD CONSTRAINT `producto_variacions_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_variacions_color_secundario_id_foreign` FOREIGN KEY (`color_secundario_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_variacions_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_variacions_talla_id_foreign` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
