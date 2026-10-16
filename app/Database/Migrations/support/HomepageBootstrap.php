<?php

namespace App\Database\Migrations\Support;

/**
 * Creates the homepage content tables from raw SQL when migrations have not been run
 * (used by the post_controller_constructor bootstrap event). Mirrors migration
 * 2026-10-17-000003_HomepageContent.
 */
class HomepageBootstrap
{
    public function ensureTables($db): void
    {
        $tables = [
            'product_categories' => "CREATE TABLE IF NOT EXISTS `product_categories` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `slug` VARCHAR(100) NOT NULL UNIQUE,
                `icon` VARCHAR(60) NULL,
                `sort_order` INT DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL
            )",
            'products' => "CREATE TABLE IF NOT EXISTS `products` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `category_id` INT UNSIGNED NULL,
                `name` VARCHAR(150) NOT NULL,
                `slug` VARCHAR(150) NOT NULL UNIQUE,
                `tagline` VARCHAR(255) NULL,
                `description` LONGTEXT NULL,
                `icon` VARCHAR(60) NULL,
                `color` VARCHAR(30) NULL,
                `hero_image` VARCHAR(255) NULL,
                `top_features` TEXT NULL,
                `demo_url` VARCHAR(255) NULL,
                `video_url` VARCHAR(255) NULL,
                `price_from` DECIMAL(10,2) NULL,
                `currency` VARCHAR(3) DEFAULT 'PKR',
                `is_featured` TINYINT(1) DEFAULT 0,
                `sort_order` INT DEFAULT 0,
                `status` ENUM('active','draft','archived') DEFAULT 'active',
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL, `deleted_at` DATETIME NULL,
                INDEX `status_cat` (`status`,`category_id`)
            )",
            'clients' => "CREATE TABLE IF NOT EXISTS `clients` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `company_name` VARCHAR(150) NOT NULL,
                `logo` VARCHAR(255) NULL,
                `website` VARCHAR(255) NULL,
                `industry` VARCHAR(100) NULL,
                `sort_order` INT DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL
            )",
            'testimonials' => "CREATE TABLE IF NOT EXISTS `testimonials` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `quote` TEXT NOT NULL,
                `name` VARCHAR(150) NOT NULL,
                `role` VARCHAR(150) NULL,
                `company` VARCHAR(150) NULL,
                `photo` VARCHAR(255) NULL,
                `company_logo` VARCHAR(255) NULL,
                `product_id` INT UNSIGNED NULL,
                `rating` TINYINT DEFAULT 5,
                `source` ENUM('site','google','facebook') DEFAULT 'site',
                `is_featured` TINYINT(1) DEFAULT 0,
                `status` ENUM('approved','pending','hidden') DEFAULT 'approved',
                `sort_order` INT DEFAULT 0,
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL, `deleted_at` DATETIME NULL,
                INDEX `feat_status` (`status`,`is_featured`)
            )",
            'success_stories' => "CREATE TABLE IF NOT EXISTS `success_stories` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `headline` VARCHAR(200) NOT NULL,
                `slug` VARCHAR(200) NOT NULL UNIQUE,
                `customer_name` VARCHAR(150) NULL,
                `role` VARCHAR(150) NULL,
                `company` VARCHAR(150) NULL,
                `industry` VARCHAR(100) NULL,
                `photo` VARCHAR(255) NULL,
                `logo` VARCHAR(255) NULL,
                `hero_image` VARCHAR(255) NULL,
                `quote` TEXT NULL,
                `challenge` LONGTEXT NULL,
                `solution` LONGTEXT NULL,
                `results` LONGTEXT NULL,
                `metrics` TEXT NULL,
                `product_id` INT UNSIGNED NULL,
                `is_featured` TINYINT(1) DEFAULT 0,
                `status` ENUM('published','draft') DEFAULT 'published',
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL, `deleted_at` DATETIME NULL,
                INDEX `story_feat` (`status`,`is_featured`)
            )",
            'integrations' => "CREATE TABLE IF NOT EXISTS `integrations` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `slug` VARCHAR(100) NOT NULL UNIQUE,
                `logo` VARCHAR(255) NULL,
                `icon` VARCHAR(60) NULL,
                `description` VARCHAR(255) NULL,
                `url` VARCHAR(255) NULL,
                `sort_order` INT DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME NULL, `updated_at` DATETIME NULL
            )",
        ];

        foreach ($tables as $sql) {
            $db->query($sql);
        }
    }
}
