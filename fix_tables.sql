RENAME TABLE `categorias` TO `categoria`;
RENAME TABLE `modelos` TO `modelo`;
RENAME TABLE `productos` TO `producto`;
RENAME TABLE `producto_imagens` TO `producto_imagen`;
RENAME TABLE `producto_variacion` TO `producto_variacion_temp`;
RENAME TABLE `producto_variacion_temp` TO `producto_variacion`;
RENAME TABLE `tallas` TO `talla`;
RENAME TABLE `colors` TO `color`;
CREATE TABLE IF NOT EXISTS `cache` (`key` varchar(255) NOT NULL, `value` mediumtext NOT NULL, `expiration` int(11) NOT NULL, PRIMARY KEY (`key`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
