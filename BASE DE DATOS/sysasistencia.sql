-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2022 a las 19:00:53
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sysasistencia_francisco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `branch_office`
--

CREATE TABLE `branch_office` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE latin1_spanish_ci NOT NULL,
  `latitude` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `longitude` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `radius` int(11) NOT NULL,
  `address` varchar(25) COLLATE latin1_spanish_ci DEFAULT NULL,
  `idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `branch_office`
--

INSERT INTO `branch_office` (`id`, `name`, `latitude`, `longitude`, `radius`, `address`, `idEmpresa`) VALUES
(1, 'SEDE CENTRAL', '-13.65082055522625', '-73.42784570892192', 50, 'Jr. Lima 450', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nomEmpresa` varchar(30) NOT NULL,
  `Direccion` varchar(30) NOT NULL,
  `Latitud` varchar(30) NOT NULL,
  `Longitud` varchar(30) NOT NULL,
  `Logo` varchar(50) DEFAULT NULL,
  `radio` varchar(50) DEFAULT NULL,
  `AperturaSistema` time NOT NULL,
  `HoraEntrada` time DEFAULT NULL,
  `HoraSalida` time NOT NULL,
  `diasHabilitados` varchar(100) NOT NULL,
  `pagoHora` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nomEmpresa`, `Direccion`, `Latitud`, `Longitud`, `Logo`, `radio`, `AperturaSistema`, `HoraEntrada`, `HoraSalida`, `diasHabilitados`, `pagoHora`) VALUES
(1, 'Jorge', 'COl psj los pinos', '-13.65055300087334', '            -73.42780364006432', 'cwil2.png', '8000', '06:00:00', '07:00:00', '12:00:00', 'LU_MA_MI_JU_VI_SÁ_DO', '10.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `IdPago` int(11) NOT NULL,
  `monto` decimal(18,2) NOT NULL,
  `nota` varchar(180) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `IdRegistro` int(11) NOT NULL,
  `LatitudEntrada` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `LongitudEntrada` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `FechaRegistro` date NOT NULL,
  `HoraEntrada` time NOT NULL,
  `HoraSalida` time DEFAULT NULL,
  `LatitudSalida` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `LongitudSalida` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Consideracion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Consideracion2` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `HoraEntradaU` time DEFAULT NULL,
  `HoraSalidaU` time DEFAULT NULL,
  `capturaEntrada` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `capturaSalida` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Observacion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `EncargadoUpdt` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombres` varchar(40) NOT NULL,
  `NumDocumento` char(10) NOT NULL,
  `password` varchar(200) NOT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `Direccion` varchar(40) DEFAULT NULL,
  `TelefCel` varchar(15) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `pagoHora` decimal(18,2) DEFAULT NULL,
  `CreadoEn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado` varchar(20) DEFAULT NULL,
  `TipoUsuario` varchar(20) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `idBranch_office` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nombres`, `NumDocumento`, `password`, `clave`, `Direccion`, `TelefCel`, `Correo`, `pagoHora`, `CreadoEn`, `Estado`, `TipoUsuario`, `foto`, `idBranch_office`) VALUES
(2, 'William Alexis Portillo Ruano', '70378801', '$2y$10$y6FYe/t2glHaDK1wipMy5ePkXar5LnkFXFhLSXoURMoQ.vsaAvUi2', '1234', NULL, NULL, NULL, NULL, '2021-03-24 07:06:43', 'ACTIVO', 'ADMINISTRADOR', 'logo.jpg', 1),
(6, 'JORGE ERNESTO PORTILLO', '12345678', '$2y$10$QwR5ullYUQ5EwwhBvvIqw.VKs1WvRWaW7iRm7GuneeYcKGKUjkjC2', '423423423', 'Jr. Santa Fe calle 343', NULL, NULL, '10.00', '2022-03-09 07:50:33', 'ACTIVO', 'PERSONAL', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `branch_office`
--
ALTER TABLE `branch_office`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`IdPago`),
  ADD KEY `fk_PagoRegistro` (`IdUsuario`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`IdRegistro`),
  ADD KEY `fk_UsuarioRegistro` (`IdUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD UNIQUE KEY `Dni` (`NumDocumento`),
  ADD KEY `idBranch_office` (`idBranch_office`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `branch_office`
--
ALTER TABLE `branch_office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `IdPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `IdRegistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `branch_office`
--
ALTER TABLE `branch_office`
  ADD CONSTRAINT `branch_office_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_PagoRegistro` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `fk_UsuarioRegistro` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idBranch_office`) REFERENCES `branch_office` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
