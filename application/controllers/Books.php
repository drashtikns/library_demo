<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {
	
	public function __construct() {
		//load database in autoload libraries 
		parent::__construct(); 
		$this->load->model('books_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}
	
	// default method to list books
	public function index() {
		$data['books']=$this->books_model->list_books();
		$data['title'] = 'Books Library';
		$this->load->view('templates/header');       
		$this->load->view('books/index',$data);
		$this->load->view('templates/footer');
	}

	// A method to issue books
	public function issue_book($id) {
		$this->load->library('form_validation');
		$data = array();
		
		if($this->input->post('bookSubmit')){
			$this->form_validation->set_rules('issue_date', 'Issue Date', 'required');
			$this->form_validation->set_rules('user_id', 'User', 'required');
			$this->form_validation->set_rules('user_id', 'User', 'callback_validate_book_allocation');
			
			if ($this->form_validation->run() === true ) {
				$post_data=array(
					'book_id' => $this->input->post('book_id'),
					'issue_date' => $this->input->post('issue_date'),
					'user_id'=> $this->input->post('user_id')
				);
				$res_issue = $this->books_model->issue_book($post_data);
				if( $res_issue ) {
					$this->session->set_flashdata('success_msg', 'Book has been issued successfully.');
                    redirect(base_url('/books'));
				} else {
					$data['error_msg'] = 'There is some error in issuing book.';
				}
			}
		}
		
		$data['title'] = 'Book Issue Details';
		$data['book'] = $this->db->get_where('books',array('id'=>$id))->row();
		$data['users'] = $this->db->get('users')->result_array();
		$data['action'] = 'issue';
		
		$this->load->view('templates/header');
		$this->load->view('books/manage_book',$data);
		$this->load->view('templates/footer');   
	}
	
	// A method to return books
	public function return_book($id) {
		$this->load->library('form_validation');
		$data = array();
		
		if($this->input->post('bookSubmit')){
			$this->form_validation->set_rules('return_date', 'Return Date', 'required');

			if ($this->form_validation->run() === true ) {
				$post_data=array(
					'book_id' => $this->input->post('book_id'),
					'return_date' => $this->input->post('return_date')
				);
				$res_issue = $this->books_model->return_book($post_data);
				if( $res_issue ) {
					$this->session->set_flashdata('success_msg', 'Book has been returned successfully.');
                    redirect(base_url('/books'));
				} else {
					$data['error_msg'] = 'There is some error in returning book.';
				}
			}
		}
		
		$data['title'] = 'Book Issue Details';
		$data['book'] = $this->db->get_where('books',array('id'=>$id))->row();
		if( $this->books_model->book_allocation_count($id) > 0 ){
			$data['allocated_book'] = $this->books_model->get_allocated_book($id);
		} else {
			$data['error_msg'] = 'This book is not yet issued.';
		}
		$data['users'] = $this->db->get('users')->result_array();
		$data['action'] = 'return';
		$this->load->view('templates/header');
		$this->load->view('books/manage_book',$data);
		$this->load->view('templates/footer');   
	}
	
	// A function to validate books allocations
	public function validate_book_allocation(){
		$book_id = $this->input->post('book_id');
		$count = $this->books_model->book_allocation_count($book_id);

		if( $count == 0 ) {
		   return true;
		}
		$this->form_validation->set_message('validate_book_allocation','This book is already issued.');
		return false;
    }
	
	// A method to check book status
	public function check_status($id) {
		$count = $this->books_model->book_allocation_count($id);
		
		if( $count == 0 ) {
			$this->session->set_flashdata('success_msg', 'This book is available.');
		} else {
			$this->session->set_flashdata('error_msg', 'This book is not available.');
		}
		
		redirect(base_url('/books'));
	}
}