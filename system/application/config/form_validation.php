<?php
$config = array(
			'save_category' => array(
								array(
										'field' => 'title',
										'label' => 'Title',
										'rules' => 'required'
									 )
								),
			'save_entry' => array(
								array(
										'field' => 'title',
										'label' => 'Title',
										'rules' => 'required'
									 )
								),
			'save_page' => array(
								array(
										'field' => 'title',
										'label' => 'Title',
										'rules' => 'required|trim|min_length[1]'
									 )
								),
			 'save_banner' => array(
								array(
										'field' => 'title',
										'label' => 'Title',
										'rules' => 'required'
									 ),
								array(
										'field' => 'url',
										'label' => 'Url',
										'rules' => 'required|min_length[12]'
									 )
								),
			'save_config' => array(
								array(
										'field' => 'admin_email',
										'label' => 'Admin Email',
										'rules' => 'required|valid_email'
									 ),
								array(
										'field' => 'contact_email',
										'label' => 'Contact Email',
										'rules' => 'required|valid_email'
									 ),
								array(
										'field' => 'login',
										'label' => 'Login',
										'rules' => 'required|alpha_dash|min_length[4]|max_length[20]'
									 )

								),
			'contact' => array(
								array(
										'field' => 'name',
										'label' => 'Name',
										'rules' => 'required'
									 ),
								array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									 ),
								array(
										'field' => 'message',
										'label' => 'Your message',
										'rules' => 'required|min_length[8]'
									 )

								),
			'submit' => array(
								array(
										'field' => 'name',
										'label' => 'Name',
										'rules' => 'required'
									 ),
								array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									 ),
								array(
										'field' => 'url',
										'label' => 'URL',
										'rules' => 'required|min_length[8]'
									 )

								)
			);