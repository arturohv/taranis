<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Heredamos de la clase CI_Controller */
class Grupos extends CI_Controller {

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
		redirect('grupos/mantenimiento');
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
			$crud->set_table('group');

			/* Le asignamos un nombre */
			$crud->set_subject('Groups');

			/* Asignamos el idioma español */
			$crud->set_language('english');

			/* Aqui le decimos a grocery que estos campos son obligatorios */
			$crud->required_fields(				
				'id_course',
                                'id_professor',
                                'name'
			);

			/* Aqui le indicamos que campos deseamos mostrar */
			$crud->columns(
				'id',
				'id_course',
                                'id_professor',
                                'name'
			);
                        
                        $crud->display_as('id_course','Course');
                        $crud->display_as('id_professor','Teacher Name');
                        $crud->display_as('name','Group Name');
                        $crud->set_relation('id_course','course','name');
                        $crud->set_relation('id_professor','professor','{first_name} {last_name}');
			
			/* Generamos la tabla */
			$output = $crud->render();
			
			/* La cargamos en la vista situada en 
			/applications/views/productos/administracion.php */
			$this->load->view('grupos/mantenimiento', $output);
			
		}catch(Exception $e){
			/* Si algo sale mal cachamos el error y lo mostramos */
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
}
