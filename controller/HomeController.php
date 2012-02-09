<?php
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Menus.php');

class HomeController
{
	public function __construct()
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'home' . DS;
	}
	
	public function index()
	{
		$menus = Menu::findMenu();
		$this->template->menus = $menus;
		
		$categories = Menu::findCategory();
		$this->template->categories = $categories;
	
		$this->template->display('index.html.php');
	}
}