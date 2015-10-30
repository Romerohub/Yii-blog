<?php
/*
 * Created on 27.09.2012
 *
 */

 class seo{
 	
 	function __construct(){
 		
 		
 		
 	}
 	
 	public function ping($siteName, $siteURL, $pageURL ){
 		
		require_once('IXR_Library.inc.php');
		  
		// Что посылаем в пингах
		// Название сайта
//		$siteName = 'WEB-технологии';
//		// Адрес сайта
//		$siteURL  = 'http://htmlweb.ru/';
//		// Адрес страницы, которая изменилась (например)
//		$pageURL  = 'http://htmlweb.ru/news/test.html';
//		// Адрес страницы с фидом
		$feedURL  = 'http://htmlweb.ru/news.rss';
		  
		/**
		* Яндекс.Блоги
		*/
		$pingClient = new IXR_Client('ping.blogs.yandex.ru', '/RPC2');
		 
		// Посылаем challange-запрос
		if (!$pingClient->query('weblogUpdates.ping', $siteName, $siteURL, $pageURL)) {
		    echo 'Ошибка ping-запроса [' .
		    $pingClient->getErrorCode().'] '.$pingClient->getErrorMessage();
		}
		else {
		    echo 'Послан ping Яндексу';
		}
		 
		/**
		* Google
		*/
		$pingClient = new IXR_Client('blogsearch.google.com', '/ping/RPC2');
		 
		// Посылаем challange-запрос
		if (!$pingClient->query('weblogUpdates.extendedPing',
		        $siteName, $siteURL, $pageURL, $feedURL)) {
		    echo 'Ошибка ping-запроса [' .
		    $pingClient->getErrorCode().'] '.$pingClient->getErrorMessage();
		}
		else {
		    echo 'Послан ping Google';
		}

 		
 		
 		
 	}
 	
 	
 	
 }