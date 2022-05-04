CREATE DATABASE IF NOT EXISTS `contato_seguro_backend`
/*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
/*!80016 DEFAULT ENCRYPTION='N' */;

USE `contato_seguro_backend`;

-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)

--

-- Host: localhost    Database: contato_seguro_backend

-- ------------------------------------------------------

-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!50503 SET NAMES utf8 */

;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */

;

/*!40103 SET TIME_ZONE='+00:00' */

;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */

;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */

;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */

;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */

;

--

-- Table structure for table `empresas`

--

DROP TABLE IF EXISTS `empresas`;

/*!40101 SET @saved_cs_client     = @@character_set_client */

;

/*!50503 SET character_set_client = utf8mb4 */

;

CREATE TABLE `empresas` (
	`id` int NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) NOT NULL,
	`cnpj` varchar(20) NOT NULL,
	`endereco` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */

;

--

-- Dumping data for table `empresas`

--

LOCK TABLES `empresas` WRITE;

/*!40000 ALTER TABLE `empresas` DISABLE KEYS */

;

INSERT INTO
	`empresas`
VALUES
	(1, 'empresa1', '1', 'rua 1'),(2, 'empresa2', '2', 'rua 2'),(3, 'empresa3', '3', 'rua 3'),(4, 'empresa4', '4', 'rua 4');

/*!40000 ALTER TABLE `empresas` ENABLE KEYS */

;

UNLOCK TABLES;

--

-- Table structure for table `empresas_usuarios`

--

DROP TABLE IF EXISTS `empresas_usuarios`;

/*!40101 SET @saved_cs_client     = @@character_set_client */

;

/*!50503 SET character_set_client = utf8mb4 */

;

CREATE TABLE `empresas_usuarios` (
	`idUsuario` int NOT NULL,
	`idEmpresa` int NOT NULL,
	UNIQUE KEY `idUsuario` (`idUsuario`, `idEmpresa`),
	KEY `idEmpresa` (`idEmpresa`),
	CONSTRAINT `empresas_usuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `empresas_usuarios_ibfk_2` FOREIGN KEY (`idEmpresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */

;

--

-- Dumping data for table `empresas_usuarios`

--

LOCK TABLES `empresas_usuarios` WRITE;

/*!40000 ALTER TABLE `empresas_usuarios` DISABLE KEYS */

;

INSERT INTO `empresas_usuarios` VALUES (1,1),(2,2),(3,3),(4,4);

/*!40000 ALTER TABLE `empresas_usuarios` ENABLE KEYS */

;

UNLOCK TABLES;

--

-- Table structure for table `usuarios`

--

DROP TABLE IF EXISTS `usuarios`;

/*!40101 SET @saved_cs_client     = @@character_set_client */

;

/*!50503 SET character_set_client = utf8mb4 */

;

CREATE TABLE `usuarios` (
	`id` int NOT NULL AUTO_INCREMENT,
	`email` varchar(255) NOT NULL,
	`telefone` varchar(20) DEFAULT '',
	`dataNascimento` date DEFAULT NULL,
	`cidadeNascimento` varchar(255) DEFAULT '',
	`nome` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */

;

--

-- Dumping data for table `usuarios`

--

LOCK TABLES `usuarios` WRITE;

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */

;

INSERT INTO
	`usuarios`
VALUES
	(
		1,
		'1@1.com',
		'1111111',
		'1999-02-06',
		'cidade1',
		'usuario1'
	),(
		2,
		'2@2.com',
		'222222',
		'1999-02-06',
		'cidade2',
		'usuario2'
	),(
		3,
		'3@3.com',
		'333333',
		'1999-02-06',
		'cidade3',
		'usuario3'
	),(
		4,
		'4@4.com',
		'444444',
		'1999-02-06',
		'cidade4',
		'usuario4'
	);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */

;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */

;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */

;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */

;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */

;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */

;

-- Dump completed on 2022-05-02 19:16:31