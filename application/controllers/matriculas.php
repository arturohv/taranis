<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Heredamos de la clase CI_Controller */
class Matriculas extends CI_Controller {

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
		redirect('matriculas/mantenimiento');
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
			$crud->set_table('registration');

			/* Le asignamos un nombre */
			$crud->set_subject('Registration');

			/* Asignamos el idioma español */
			$crud->set_language('english');

			/* Aqui le decimos a grocery que estos campos son obligatorios */
			$crud->required_fields(				
				'id_career',
                                'id_group',
                                'id_student'
			);

			/* Aqui le indicamos que campos deseamos mostrar */
			$crud->columns(
				'id',
				'id_career',
                                'id_group',
                                'id_student'
			);
                        
                        /*Forma en que se despliegan las etiquetas*/ 
                        $crud->display_as('id_career','Career');
                         $crud->display_as('id_group','Group');
                         $crud->display_as('id_student','Student Name');
                         
                        /*Establece las relaciones para los comboBOX*/
                         $crud->set_relation('id_career','career','name');
                         $crud->set_relation('id_group','group','name');
                         $crud->set_relation('id_student','student','{first_name} {last_name}');
			
			/* Generamos la tabla */
			$output = $crud->render();
			
			/* La cargamos en la vista situada en 
			/applications/views/productos/administracion.php */
			$this->load->view('matriculas/mantenimiento', $output);
			
		}catch(Exception $e){
			/* Si algo sale mal cachamos el error y lo mostramos */
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
}

