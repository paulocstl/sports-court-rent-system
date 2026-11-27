CREATE DATABASE  IF NOT EXISTS `` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `arenahub_teste_importacao`;
-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: arenahub_teste_importacao
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(60) NOT NULL,
  `cpf` char(11) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status_cadastro` varchar(10) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (2,'Paulo Teste','22222222222','41990000002','paulo@gmail.com','ativo',NULL),(3,'Berger Teste','33333333333','41990000003','berger@gmail.com','ativo',NULL),(4,'Guilherme Teste','44444444444','41990000004','guilherme@gmail.com','ativo',NULL),(5,'Eduardo Teste','55555555555','41990000005','eduardo@gmail.com','ativo',NULL),(6,'Inacio Teste','66666666666','41990000006','inacio@gmail.com','ativo',NULL),(7,'Fernando Teste','77777777777','41990000007','fernando@gmail.com','ativo',NULL),(8,'Abimael Teste','88888888888','41990000008','abimael@gmail.com','ativo',NULL),(9,'paulo cesar','12345678900','41922221111','paulocastelhano@gmail.com','ativo','$2y$10$kSc/MvQ3FsVZ15UdchYREuF.QaOEx4z1Rs6tl6LguFc1o13e4fDpa'),(11,'gui berger','01234567890','41955558888','guiberger@gmail.com','ativo','$2y$10$ts6mXPo/iZWGgcluzl28Q.5ojKNCZxHAViu7GAUP9XFcspCmldnYm'),(12,'Paulo Castelhano','13297539925','+5541988219067','paulocastelhano84@gmail.com','ativo','$2y$10$EB3BdiCnhHb428YNWhARFe.JxSotHkRo.mE4KQXYK1X/pAI4lOrN2');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `razao_social` varchar(100) NOT NULL,
  `nome_fantasia` varchar(80) NOT NULL,
  `cnpj` char(14) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `status_cadastro` varchar(10) NOT NULL,
  PRIMARY KEY (`id_empresa`),
  UNIQUE KEY `cnpj` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (2,'Empresa Teste 2 Ltda','Arena Teste 2','80000002000120','4130000002','empresa2@example.com','Rua Teste, 2, Centro, Curitiba, 80000000','ativa'),(3,'Empresa Teste 3 Ltda','Arena Teste 3','80000003000130','4130000003','empresa3@example.com','Rua Teste, 3, Centro, Curitiba, 80000000','ativa'),(4,'Empresa Teste 4 Ltda','Arena Teste 4','80000004000140','4130000004','empresa4@example.com','Rua Teste, 4, Centro, Curitiba, 80000000','ativa'),(5,'Empresa Teste 5 Ltda','Arena Teste 5','80000005000150','4130000005','empresa5@example.com','Rua Teste, 5, Centro, Curitiba, 80000000','ativa'),(6,'Empresa Teste 6 Ltda','Arena Teste 6','80000006000160','4130000006','empresa6@example.com','Rua Teste, 6, Centro, Curitiba, 80000000','ativa'),(7,'Empresa Teste 7 Ltda','Arena Teste 7','80000007000170','4130000007','empresa7@example.com','Rua Teste, 7, Centro, Curitiba, 80000000','ativa'),(8,'Empresa Teste 8 Ltda','Arena Teste 8','80000008000180','4130000008','empresa8@example.com','Rua Teste, 8, Centro, Curitiba, 80000000','ativa'),(9,'Empresa Teste 9 Ltda','Arena Teste 9','80000009000190','4130000009','empresa9@example.com','Rua Teste, 9, Centro, Curitiba, 90000000','ativa');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `esporte`
--

DROP TABLE IF EXISTS `esporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `esporte` (
  `id_esporte` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` varchar(300) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id_esporte`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `esporte`
--

LOCK TABLES `esporte` WRITE;
/*!40000 ALTER TABLE `esporte` DISABLE KEYS */;
INSERT INTO `esporte` VALUES (1,'Futsal',NULL,'ativo'),(2,'Basquete',NULL,'ativo'),(3,'Futevôlei',NULL,'ativo'),(4,'Tênis',NULL,'ativo'),(5,'Beach tennis',NULL,'ativo'),(6,'Handebol',NULL,'ativo'),(7,'Badminton',NULL,'ativo'),(8,'Futebol society',NULL,'ativo');
/*!40000 ALTER TABLE `esporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario_funcionamento`
--

DROP TABLE IF EXISTS `horario_funcionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario_funcionamento` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `id_quadra` int(11) NOT NULL,
  `dia_semana` varchar(15) NOT NULL,
  `hora_abertura` time NOT NULL,
  `hora_encerramento` time NOT NULL,
  `intervalo_reservas` int(11) NOT NULL,
  PRIMARY KEY (`id_horario`),
  KEY `fk_horario_quadra` (`id_quadra`),
  CONSTRAINT `fk_horario_quadra` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario_funcionamento`
--

LOCK TABLES `horario_funcionamento` WRITE;
/*!40000 ALTER TABLE `horario_funcionamento` DISABLE KEYS */;
INSERT INTO `horario_funcionamento` VALUES (2,2,'segunda-feira','08:00:00','22:00:00',60),(3,3,'segunda-feira','09:00:00','22:00:00',60),(4,4,'segunda-feira','08:00:00','21:00:00',60),(5,5,'segunda-feira','07:00:00','20:00:00',60),(6,6,'segunda-feira','08:00:00','23:00:00',60),(7,7,'segunda-feira','09:00:00','21:00:00',60),(8,8,'segunda-feira','08:00:00','20:00:00',60),(9,9,'segunda-feira','12:00:00','18:00:00',30),(10,2,'quarta-feira','08:00:00','22:00:00',60),(11,2,'quinta-feira','08:00:00','22:00:00',60),(12,2,'sexta-feira','08:00:00','22:00:00',60);
/*!40000 ALTER TABLE `horario_funcionamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_material_reserva`
--

DROP TABLE IF EXISTS `item_material_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_material_reserva` (
  `id_reserva` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_reserva`,`id_material`),
  KEY `fk_item_material` (`id_material`),
  CONSTRAINT `fk_item_material` FOREIGN KEY (`id_material`) REFERENCES `material_esportivo` (`id_material`),
  CONSTRAINT `fk_item_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_material_reserva`
--

LOCK TABLES `item_material_reserva` WRITE;
/*!40000 ALTER TABLE `item_material_reserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_material_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_esportivo`
--

DROP TABLE IF EXISTS `material_esportivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_esportivo` (
  `id_material` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `descricao` varchar(300) DEFAULT NULL,
  `quantidade_total` int(11) NOT NULL,
  `valor_aluguel` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_material`),
  KEY `fk_material_empresa` (`id_empresa`),
  CONSTRAINT `fk_material_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_esportivo`
--

LOCK TABLES `material_esportivo` WRITE;
/*!40000 ALTER TABLE `material_esportivo` DISABLE KEYS */;
INSERT INTO `material_esportivo` VALUES (2,2,'Bola de futsal','Bola para futsal',10,10.00,'disponivel'),(3,3,'Bola de basquete','Bola para basquete',8,12.00,'disponivel'),(4,4,'Bola de volei','Bola para volei',12,10.00,'disponivel'),(5,5,'Raquete de tenis','Raquete para tenis',6,20.00,'disponivel'),(6,6,'Raquete de beach tennis','Raquete para beach tennis',8,15.00,'disponivel'),(7,7,'Bola de handebol','Bola para handebol',10,10.00,'disponivel'),(8,8,'Raquete de badminton','Raquete para badminton',6,12.00,'disponivel');
/*!40000 ALTER TABLE `material_esportivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quadra`
--

DROP TABLE IF EXISTS `quadra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quadra` (
  `id_quadra` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `descricao` varchar(300) DEFAULT NULL,
  `tipo_piso` varchar(30) NOT NULL,
  `cobertura` tinyint(1) NOT NULL,
  `capacidade` int(11) NOT NULL,
  `valor_hora` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id_quadra`),
  KEY `fk_quadra_empresa` (`id_empresa`),
  CONSTRAINT `fk_quadra_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quadra`
--

LOCK TABLES `quadra` WRITE;
/*!40000 ALTER TABLE `quadra` DISABLE KEYS */;
INSERT INTO `quadra` VALUES (2,2,'Quadra 2','Quadra de futsal','cimento',1,12,100.00,'ativa'),(3,3,'Quadra 3','Quadra de basquete','madeira',1,12,120.00,'ativa'),(4,4,'Quadra 4','Quadra de futevolei','madeira',1,14,90.00,'ativa'),(5,5,'Quadra 5','Quadra de tenis','cimento',0,4,80.00,'ativa'),(6,6,'Quadra 6','Quadra de beach tennis','areia',0,4,100.00,'ativa'),(7,7,'Quadra 7','Quadra de handebol','cimento',1,16,110.00,'ativa'),(8,8,'Quadra 8','Quadra de badminton','madeira',1,4,70.00,'ativa'),(9,9,'Quadra 9','Quadra de fut7','society',1,14,100.00,'ativa');
/*!40000 ALTER TABLE `quadra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quadra_esporte`
--

DROP TABLE IF EXISTS `quadra_esporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quadra_esporte` (
  `id_quadra` int(11) NOT NULL,
  `id_esporte` int(11) NOT NULL,
  PRIMARY KEY (`id_quadra`,`id_esporte`),
  KEY `fk_quadra_esporte_esporte` (`id_esporte`),
  CONSTRAINT `fk_quadra_esporte_esporte` FOREIGN KEY (`id_esporte`) REFERENCES `esporte` (`id_esporte`),
  CONSTRAINT `fk_quadra_esporte_quadra` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quadra_esporte`
--

LOCK TABLES `quadra_esporte` WRITE;
/*!40000 ALTER TABLE `quadra_esporte` DISABLE KEYS */;
INSERT INTO `quadra_esporte` VALUES (2,1),(3,2),(4,3),(5,4),(6,5),(7,6),(8,7),(9,8);
/*!40000 ALTER TABLE `quadra_esporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_quadra` int(11) NOT NULL,
  `data_reserva` date NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  `data_hora_registro` datetime NOT NULL,
  `status` varchar(15) NOT NULL,
  `observacao` varchar(500) DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reserva_cliente` (`id_cliente`),
  KEY `fk_reserva_quadra` (`id_quadra`),
  CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_reserva_quadra` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (1,11,9,'2026-11-30','12:00:00','12:30:00','2026-11-23 08:26:27','confirmada',NULL,50.00),(2,11,2,'2026-11-30','12:00:00','13:00:00','2026-11-23 08:31:03','confirmada',NULL,100.00);
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-23  9:07:47
