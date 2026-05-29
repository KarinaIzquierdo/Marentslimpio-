CREATE TABLE IF NOT EXISTS `carrito_detalle` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carrito_id` bigint(20) UNSIGNED NOT NULL,
  `producto_variacion_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrito_id` (`carrito_id`),
  KEY `producto_variacion_id` (`producto_variacion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
