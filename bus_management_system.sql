/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : localhost:3306
 Source Schema         : bus_management_system

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 27/08/2020 17:12:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for booking
-- ----------------------------
DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking`  (
  `booking_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `journey_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `booking_time` datetime(0) NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount` double(10, 2) UNSIGNED NULL DEFAULT NULL,
  `order_status` enum('Draft','AwaitingClientPayment','AwaitingBookingConfirmation','Cancelled','Complete') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Draft',
  PRIMARY KEY (`booking_id`) USING BTREE,
  INDEX `userId`(`email`) USING BTREE,
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for booking_detail
-- ----------------------------
DROP TABLE IF EXISTS `booking_detail`;
CREATE TABLE `booking_detail`  (
  `booking_id` int(10) UNSIGNED NOT NULL,
  `booking_detail_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seat_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `assignedTo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journeyId` int(10) UNSIGNED NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`booking_detail_id`) USING BTREE,
  INDEX `seat_id`(`seat_id`) USING BTREE,
  INDEX `booking_id`(`booking_id`) USING BTREE,
  INDEX `journeyId`(`journeyId`) USING BTREE,
  CONSTRAINT `booking_detail_ibfk_1` FOREIGN KEY (`seat_id`) REFERENCES `bus_seat` (`seat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `booking_detail_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `booking_detail_ibfk_3` FOREIGN KEY (`journeyId`) REFERENCES `journey` (`journey_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'The details of a booking' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bus
-- ----------------------------
DROP TABLE IF EXISTS `bus`;
CREATE TABLE `bus`  (
  `registration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `coach` enum('AC','NON-AC') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `color` enum('Red','Green','Blue','Orange','Black') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_of_seats` int(255) NULL DEFAULT 25,
  `imgurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'default.png',
  `normal_seats` int(255) UNSIGNED NULL DEFAULT 0,
  `vip_seats` int(255) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`registration`) USING BTREE,
  UNIQUE INDEX `registration`(`registration`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bus_seat
-- ----------------------------
DROP TABLE IF EXISTS `bus_seat`;
CREATE TABLE `bus_seat`  (
  `seat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `isUsable` tinyint(1) UNSIGNED NULL DEFAULT 1,
  `isPremium` tinyint(1) NULL DEFAULT 0,
  `busId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `seatName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A',
  PRIMARY KEY (`seat_id`) USING BTREE,
  INDEX `busId`(`busId`) USING BTREE,
  CONSTRAINT `bus_seat_ibfk_1` FOREIGN KEY (`busId`) REFERENCES `bus` (`registration`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 309 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for crew
-- ----------------------------
DROP TABLE IF EXISTS `crew`;
CREATE TABLE `crew`  (
  `crew_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `crew_type` enum('Driver','Conductor','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `crew_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`crew_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for journey
-- ----------------------------
DROP TABLE IF EXISTS `journey`;
CREATE TABLE `journey`  (
  `journey_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departure_date` date NULL DEFAULT NULL,
  `departure_time` time(0) NULL DEFAULT NULL,
  `vehicle_reg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `route_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `driver_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `conductor_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `normal_price` decimal(10, 2) NULL DEFAULT NULL,
  `premium_price` decimal(10, 2) NULL DEFAULT NULL,
  `driver_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `conductor_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`journey_id`) USING BTREE,
  UNIQUE INDEX `departure_date`(`departure_date`, `departure_time`, `vehicle_reg`) USING BTREE,
  UNIQUE INDEX `departure_date_2`(`departure_date`, `driver_id`) USING BTREE,
  UNIQUE INDEX `departure_date_3`(`departure_date`, `conductor_id`) USING BTREE,
  UNIQUE INDEX `departure_date_4`(`departure_date`, `vehicle_reg`, `driver_id`) USING BTREE,
  UNIQUE INDEX `departure_date_5`(`departure_date`, `vehicle_reg`, `conductor_id`) USING BTREE,
  UNIQUE INDEX `departure_date_6`(`departure_date`, `vehicle_reg`, `route_id`) USING BTREE,
  INDEX `FK_vehicleReg`(`vehicle_reg`) USING BTREE,
  INDEX `FK_route`(`route_id`) USING BTREE,
  INDEX `driver_id`(`driver_id`) USING BTREE,
  INDEX `conductor_id`(`conductor_id`) USING BTREE,
  CONSTRAINT `FK_route` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_vehicleReg` FOREIGN KEY (`vehicle_reg`) REFERENCES `bus` (`registration`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `journey_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `journey_ibfk_2` FOREIGN KEY (`conductor_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount` double(10, 2) NULL DEFAULT NULL,
  `booking_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `transaction_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_id`) USING BTREE,
  INDEX `booking_id`(`booking_id`) USING BTREE,
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for route
-- ----------------------------
DROP TABLE IF EXISTS `route`;
CREATE TABLE `route`  (
  `route_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `route_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `start_point` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `end_point` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `distance` int(10) UNSIGNED NULL DEFAULT 356,
  `duration` int(10) UNSIGNED NULL DEFAULT 360,
  PRIMARY KEY (`route_id`) USING BTREE,
  UNIQUE INDEX `route_name`(`route_name`, `start_point`, `end_point`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mobile` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `userType` enum('customer','admin') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'customer',
  `status` tinyint(3) UNSIGNED NULL DEFAULT 1,
  PRIMARY KEY (`userId`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
