-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2023 a las 18:43:44
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `intranet_asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idArea` int(10) NOT NULL,
  `name_area` varchar(200) NOT NULL,
  `description_area` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `idState` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idArea`, `name_area`, `description_area`, `created_at`, `idState`) VALUES
(1, 'Tecnologías', 'Encargada de gestionar la infraestructura tecnológica y el desarrollo de soluciones digitales para mejorar la eficiencia y la innovación en la organización.', '2023-08-25 09:27:07', 1),
(2, 'Comercial', 'Responsable de la promoción, ventas y relaciones con los clientes, buscando el crecimiento de los ingresos y la satisfacción del cliente.', '2023-08-25 09:27:07', 1),
(3, 'Recursos Humanos', 'Se ocupa de la gestión del personal, la adquisición de talento, el desarrollo profesional y el bienestar de los empleados.', '2023-08-25 09:27:07', 1),
(4, 'Finanzas', 'Maneja las operaciones financieras de la organización, incluyendo contabilidad, presupuesto, inversión y análisis financiero.', '2023-08-25 09:27:07', 1),
(5, 'Gerencia', 'El área de gerencia es responsable de establecer la visión estratégica de la organización, tomar decisiones clave y supervisar el funcionamiento general para lograr los objetivos corporativos y garant', '2023-08-25 10:20:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistance`
--

CREATE TABLE `assistance` (
  `idAssistance` int(10) NOT NULL,
  `observation` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `idDepartmentUser` int(10) NOT NULL,
  `idType` int(10) NOT NULL,
  `idService` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `department`
--

CREATE TABLE `department` (
  `idDepartment` int(11) NOT NULL,
  `name_department` varchar(200) NOT NULL,
  `description_department` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `idState` int(10) NOT NULL DEFAULT 1,
  `idArea` int(10) NOT NULL,
  `idTime` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `department`
--

INSERT INTO `department` (`idDepartment`, `name_department`, `description_department`, `created_at`, `idState`, `idArea`, `idTime`) VALUES
(1, 'Desarrollo de Software', 'Este departamento está encargado de diseñar, desarrollar y mantener tanto aplicaciones internas como externas de la organización. Su objetivo es crear soluciones digitales que se alineen con las neces', '2023-08-25 09:37:22', 1, 1, 1),
(2, 'Infraestructura y Operaciones', 'La función principal de este departamento es administrar la infraestructura tecnológica de la organización, incluyendo servidores, sistemas operativos y redes. Además, ofrece soporte técnico a los usu', '2023-08-25 09:37:22', 1, 1, 1),
(3, 'Seguridad de la Información', 'Este departamento se dedica a garantizar la seguridad de los sistemas y la información de la organización. Esto implica la implementación de medidas de ciberseguridad, la gestión de riesgos relacionad', '2023-08-25 09:37:22', 2, 1, 1),
(4, 'Ventas', 'El departamento de ventas se encarga de promover los productos o servicios de la organización y cerrar acuerdos con clientes potenciales. Su objetivo es impulsar el crecimiento de los ingresos y asegu', '2023-08-25 09:37:22', 1, 2, 1),
(5, 'Marketing y Comunicaciones', 'Este departamento tiene la responsabilidad de crear y ejecutar estrategias de marketing que aumenten la visibilidad y la imagen de la marca. Además, gestiona las comunicaciones internas y externas, in', '2023-08-25 09:37:22', 1, 2, 1),
(6, 'Servicio al Cliente', 'El departamento de servicio al cliente se dedica a brindar asistencia y soporte a los clientes después de la compra. Su enfoque está en resolver consultas, problemas y reclamaciones de manera eficient', '2023-08-25 09:37:22', 1, 2, 3),
(7, 'Contratación y Selección', 'Este departamento se encarga de atraer, evaluar y contratar nuevo talento para la organización. Gestiona el proceso de selección, las entrevistas y la integración de nuevos empleados.', '2023-08-25 09:37:22', 1, 3, 2),
(8, 'Desarrollo Organizacional', 'El departamento de desarrollo organizacional se concentra en el crecimiento profesional y el bienestar de los empleados. Esto incluye la capacitación, el desarrollo de habilidades, la gestión del dese', '2023-08-25 09:37:22', 1, 3, 2),
(9, 'Administración de Personal', 'Este departamento se encarga de atraer, evaluar y contratar nuevo talento para la organización. Gestiona el proceso de selección, las entrevistas y la integración de nuevos empleados.', '2023-08-25 09:37:22', 1, 3, 2),
(10, 'Contabilidad', 'El departamento de contabilidad es responsable de registrar, analizar y reportar las transacciones financieras de la organización. Supervisa el ciclo contable, incluyendo cuentas por pagar y cuentas p', '2023-08-25 09:37:22', 1, 4, 1),
(11, 'Tesorería y Finanzas', 'Este departamento maneja la liquidez financiera de la organización. Gestiona la tesorería, optimiza el flujo de efectivo, administra las inversiones y se asegura de que la organización tenga los recur', '2023-08-25 09:37:22', 1, 4, 2),
(12, 'Análisis Financiero', 'El departamento de análisis financiero se dedica a examinar los datos financieros y realizar proyecciones para respaldar la toma de decisiones estratégicas. Realiza análisis de presupuesto, pronóstico', '2023-08-25 09:37:22', 1, 4, 3),
(13, 'Dirección Estratégica', 'Este departamento está encargado de definir la dirección a largo plazo de la organización. Analiza tendencias, identifica oportunidades de mercado y establece objetivos estratégicos para el crecimient', '2023-08-25 10:26:53', 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `department_user`
--

CREATE TABLE `department_user` (
  `idDepartmentUser` int(10) NOT NULL,
  `idDepartment` int(10) NOT NULL,
  `idUser` int(10) NOT NULL,
  `idState` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `department_user`
--

INSERT INTO `department_user` (`idDepartmentUser`, `idDepartment`, `idUser`, `idState`) VALUES
(1, 1, 1, 1),
(2, 13, 2, 1),
(3, 13, 6, 1),
(4, 3, 3, 1),
(5, 4, 4, 1),
(6, 4, 5, 1),
(7, 4, 7, 1),
(8, 7, 8, 1),
(9, 7, 9, 1),
(10, 12, 10, 1),
(11, 10, 11, 1),
(12, 5, 12, 1),
(13, 5, 13, 1),
(14, 11, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `idProfile` int(10) NOT NULL,
  `name_profile` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images_profile/default.png',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `idState` int(10) NOT NULL DEFAULT 1,
  `idUser` int(10) NOT NULL,
  `idRol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`idProfile`, `name_profile`, `lastname`, `email`, `image`, `created_at`, `idState`, `idUser`, `idRol`) VALUES
(1, 'Bryan Daniell', 'Arrivasplata Rojas', 'bryanarrivasplata.rojas@gmail.com', 'images_profile/admin.png', '2023-08-25 09:53:54', 1, 1, 1),
(2, 'Pedro', 'Salaz', 'pedrosalaz@gmail.com\r\n', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 2, 2),
(3, 'David', 'Vera Fuentes', 'dverafuentes@gmail.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 6, 2),
(4, 'Felix', 'Juston', 'felixjuston@gmail.com', 'images_profile/worker.png', '2023-08-25 09:53:54', 1, 3, 3),
(5, 'Juan', 'Pérez García', 'juan.perez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 4, 3),
(6, 'Laura', 'Fernández Pérez', 'laura.fernandez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 5, 3),
(7, 'Javier', 'López Rodríguez', 'javier.lopez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 7, 3),
(8, 'Ana', 'Martínez Sánchez', 'ana.martinez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 8, 3),
(9, 'Carmen', 'García Fernández', 'carmen.garcia@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 9, 3),
(10, 'David', 'Ruiz González', 'david.ruiz@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 10, 3),
(11, 'Patricia', 'Sánchez Martínez', 'patricia.sanchez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 11, 3),
(12, 'Alejandro', 'Pérez Rodríguez', 'alejandro.perez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 12, 3),
(13, 'Luis', 'Torres Pérez', 'luis.torres@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 13, 3),
(14, 'Carlos', 'González Martínez', 'carlos.gonzalez@example.com', 'images_profile/default.png', '2023-08-25 09:53:54', 1, 14, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(10) NOT NULL,
  `name_rol` varchar(200) NOT NULL,
  `name_rol_view` varchar(200) NOT NULL,
  `description_rol` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `name_rol`, `name_rol_view`, `description_rol`, `created_at`) VALUES
(1, 'admin', 'Administrador', 'Realiza las funciones de edición completa de la BD visualizando a todos los trabajadores', '2023-08-25 09:19:15'),
(2, 'executive', 'Ejecutivo', 'Alta dirección para visualizar a todos los trabajadores', '2023-08-25 09:19:15'),
(3, 'worker', 'Trabajador', 'Visualizar y modificar únicamente lo concerniente al seguimiento de sus labores.', '2023-08-25 09:19:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service`
--

CREATE TABLE `service` (
  `idService` int(10) NOT NULL,
  `name_service` varchar(200) NOT NULL,
  `description_service` varchar(200) NOT NULL,
  `time_seconds` int(6) DEFAULT 0,
  `position` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `service`
--

INSERT INTO `service` (`idService`, `name_service`, `description_service`, `time_seconds`, `position`) VALUES
(1, 'Gestión', 'Labores del trabajador en su día laboral', NULL, 0),
(2, 'Break', 'Pequeño receso del personal', 600, 1),
(3, 'Almuerzo', 'Tiempo para almorzar del trabajador', 3600, 2),
(4, 'Baño', 'Necesidades primordial del trabajador', 0, 3),
(5, 'Otros', 'Cualquier otra actividad del trabajador', 0, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `state`
--

CREATE TABLE `state` (
  `idState` int(10) NOT NULL,
  `name_state` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `state`
--

INSERT INTO `state` (`idState`, `name_state`) VALUES
(2, 'disabled'),
(1, 'enabled');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `time`
--

CREATE TABLE `time` (
  `idTime` int(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `time`
--

INSERT INTO `time` (`idTime`, `start_time`, `end_time`, `created_at`) VALUES
(1, '09:00:00', '19:00:00', '2023-08-25 09:22:20'),
(2, '09:00:00', '18:00:00', '2023-08-25 09:23:01'),
(3, '10:00:00', '19:30:00', '2023-08-25 09:23:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type`
--

CREATE TABLE `type` (
  `idType` int(10) NOT NULL,
  `name_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `type`
--

INSERT INTO `type` (`idType`, `name_type`) VALUES
(1, 'Entrada'),
(2, 'Salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(10) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `usuario`, `password`) VALUES
(1, 'admin', '$2y$10$lF/3ycfWHVr2Y712isETq.OFLeGAleImf7wFIeowvavxufJdL/h7m'),
(2, 'executive', '$2y$10$YI5gMsPbMXg2u9vDTxqkv.f06TxVF8HyR7cumsLHpc/VsRwFoAWzS'),
(3, 'worker', '$2y$10$wCfWQqhTdcmQLKO01pp18O1LTc9MWQ0FtZ26FvVzduwcIDcO8JS1G'),
(4, 'worker1', '$2y$10$TV0R9GHupxPaJezOUflpme4kUpFQRM12.M4fUsMEgjVwBZ124ZGTO'),
(5, 'worker2', '$2y$10$j/UX4GGiy2eKB4YPQ4WxX.pHz7lH8SHAOgAUS0YCBl012UOX2q/mO'),
(6, 'executive1', '$2y$10$vNwvV/LNrlvwqUfirS6R2ev2Eb8fQ5sMzgDhHmQusNFesOFFHWpzm'),
(7, 'worker3', '$2y$10$EhaL9GDGCFF7wJSVHOKbh.tU4aLFOZ0LV4zP3OlAZufOXViOh/cd2'),
(8, 'worker4', '$2y$10$G3ZwXFDUU4rrWzcaOuZLEuKTC2ebTtM6OMAvH98wCJBq68OFAKbum'),
(9, 'worker5', '$2y$10$tOxO3qOd6INr/KxT2mKkE.l0qV9/v1lZxk6qcZEZcvTjxDy4dAU96'),
(10, 'worker6', '$2y$10$6QIrMVesdAEnZdFSTl2FwujBMDw4hFv/uaFy7kPxx66Ui/.syDclS'),
(11, 'worker7', '$2y$10$I4kmIuYPqlbBy12JhxCKP.7pygsx9jmPzYiVoBXCTP8P/prD.oF3y'),
(12, 'worker8', '$2y$10$bH.y6h7DMGCkplTsgwkKReHexV57ZmlN5irSvhytNK7ci0jsUugGe'),
(13, 'worker9', '$2y$10$MoKL/R5Nw6Am3S1so70qAuTbP3.LWaqw3OBSxRxT8/Sxh9kxErw9C'),
(14, 'worker10', '$2y$10$nyRRCmwLBGP3euo8Hdhz8uLnXt1abiXKa0EvwhmIvwUwcCLVSbks6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idArea`),
  ADD UNIQUE KEY `name_area` (`name_area`),
  ADD KEY `area_state` (`idState`);

--
-- Indices de la tabla `assistance`
--
ALTER TABLE `assistance`
  ADD PRIMARY KEY (`idAssistance`),
  ADD KEY `assistance_service` (`idService`),
  ADD KEY `assistance_type` (`idType`),
  ADD KEY `assistance_department_user` (`idDepartmentUser`);

--
-- Indices de la tabla `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`idDepartment`),
  ADD UNIQUE KEY `name_department` (`name_department`),
  ADD KEY `department_area` (`idArea`),
  ADD KEY `department_time` (`idTime`),
  ADD KEY `department_state` (`idState`);

--
-- Indices de la tabla `department_user`
--
ALTER TABLE `department_user`
  ADD PRIMARY KEY (`idDepartmentUser`),
  ADD KEY `department_user_department` (`idDepartment`),
  ADD KEY `department_user_user` (`idUser`),
  ADD KEY `department_user_state` (`idState`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`idProfile`),
  ADD UNIQUE KEY `idUser` (`idUser`),
  ADD UNIQUE KEY `idUser_2` (`idUser`),
  ADD KEY `profile_rol` (`idRol`),
  ADD KEY `profile_state` (`idState`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `name_rol` (`name_rol`);

--
-- Indices de la tabla `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`),
  ADD UNIQUE KEY `name_state_service` (`name_service`);

--
-- Indices de la tabla `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`idState`),
  ADD UNIQUE KEY `name_state` (`name_state`);

--
-- Indices de la tabla `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`idTime`);

--
-- Indices de la tabla `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`idType`),
  ADD UNIQUE KEY `name_type` (`name_type`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `user` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idArea` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `assistance`
--
ALTER TABLE `assistance`
  MODIFY `idAssistance` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `department`
--
ALTER TABLE `department`
  MODIFY `idDepartment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `department_user`
--
ALTER TABLE `department_user`
  MODIFY `idDepartmentUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `idProfile` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `service`
--
ALTER TABLE `service`
  MODIFY `idService` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `state`
--
ALTER TABLE `state`
  MODIFY `idState` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `time`
--
ALTER TABLE `time`
  MODIFY `idTime` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `type`
--
ALTER TABLE `type`
  MODIFY `idType` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_state` FOREIGN KEY (`idState`) REFERENCES `state` (`idState`);

--
-- Filtros para la tabla `assistance`
--
ALTER TABLE `assistance`
  ADD CONSTRAINT `assistance_department_user` FOREIGN KEY (`idDepartmentUser`) REFERENCES `department_user` (`idDepartmentUser`),
  ADD CONSTRAINT `assistance_service` FOREIGN KEY (`idService`) REFERENCES `service` (`idService`),
  ADD CONSTRAINT `assistance_type` FOREIGN KEY (`idType`) REFERENCES `type` (`idType`);

--
-- Filtros para la tabla `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_area` FOREIGN KEY (`idArea`) REFERENCES `area` (`idArea`),
  ADD CONSTRAINT `department_state` FOREIGN KEY (`idState`) REFERENCES `state` (`idState`),
  ADD CONSTRAINT `department_time` FOREIGN KEY (`idTime`) REFERENCES `time` (`idTime`);

--
-- Filtros para la tabla `department_user`
--
ALTER TABLE `department_user`
  ADD CONSTRAINT `department_user_department` FOREIGN KEY (`idDepartment`) REFERENCES `department` (`idDepartment`),
  ADD CONSTRAINT `department_user_state` FOREIGN KEY (`idState`) REFERENCES `state` (`idState`),
  ADD CONSTRAINT `department_user_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  ADD CONSTRAINT `profile_state` FOREIGN KEY (`idState`) REFERENCES `state` (`idState`),
  ADD CONSTRAINT `profile_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
