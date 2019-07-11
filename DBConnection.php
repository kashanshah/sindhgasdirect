<?php
if($_SERVER["HTTP_HOST"] == "dev.sindhgasdirect.com" || $_SERVER["HTTP_HOST"] == "localhost") {

    define("DB_HOST", "localhost");
    define("DB_NAME", "sindhgasdirect");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "password");
}else {

    define("DB_HOST", "localhost");
    define("DB_NAME", "et786999_sgd2");
    define("DB_USERNAME", "et786999_sgd2");
    define("DB_PASSWORD", "123sgd123?");
}
//	define("DB_HOST", "localhost");
//	define("DB_NAME", "et786999_sindhgasv11");
//	define("DB_USERNAME", "et786999_sgdv1");
//	define("DB_PASSWORD", "sindhgas123?");
