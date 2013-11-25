<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Heredamos de la clase CI_Controller */
class Usuarios extends CI_Controller {

	function __construct() 
	{
		
		parent::__construct();

		/* Cargamos la base de datos */
		$this->load->database();

		/* Cargamos la libreria*/
		$this->load->library('grocery_crud');

		/* Añadimos el helper al controlador */
		$this->load->helper('url');
	}

	function index() 
	{
		/*
		 * Mandamos todo lo que llegue a la funcion
		 * administracion().
		 **/
		redirect('usuarios/mantenimiento');
	}

	/*
	 * 
 	 **/
	function mantenimiento()
	{
		try{

			/* Creamos el objeto */
			$crud = new grocery_CRUD();

			/* Seleccionamos el tema */
			$crud->set_theme('datatables');

			/* Seleccionmos el nombre de la tabla de nuestra base de datos*/
			$crud->set_table('user');

			/* Le asignamos un nombre */
			$crud->set_subject('User');

			/* Asignamos el idioma español */
			$crud->set_language('english');

			/* Aqui le decimos a grocery que estos campos son obligatorios */
			$crud->required_fields(
				'user_type',
				'document_id',
				'full_name', 
				'email',
                                'password'
			);

			/* Aqui le indicamos que campos deseamos mostrar */
			$crud->columns(
				'id',
                                'user_type',
				'document_id',
				'full_name', 
				'email',
                                'is_active',
                                'is_sa'
                                
			);
                        
                      /*Establece las relaciones para los comboBOX*/
                         $crud->set_relation('user_type','user_types','type');
                         
                         $crud->field_type('password', 'password');
                         $crud->field_type('is_active','true_false');
                         $crud->field_type('is_sa','true_false');
                         $crud->unset_fields('is_active','is_sa');
                         
                         $crud->display_as('is_active','Is Active');
                         $crud->display_as('is_sa','Is Super Administrator');
			
			/* Generamos la tabla */
			$output = $crud->render();
			
			/* La cargamos en la vista situada en 
			/applications/views/productos/administracion.php */
			$this->load->view('usuarios/mantenimiento', $output);
			
		}catch(Exception $e){
			/* Si algo sale mal cachamos el error y lo mostramos */
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
}