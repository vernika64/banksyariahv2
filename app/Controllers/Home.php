<?php

namespace App\Controllers;

class Home extends BaseController
{
	protected $modelUser;

	public function __construct()
	{
		$this->modelUser = new \App\Models\Cpaneluser();
	}
	public function index()
	{
		return view('welcome_message');
	}
	public function cobatabel()
	{
		dd($this->modelUser->findAll());
	}
}
