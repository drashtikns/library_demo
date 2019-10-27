<?php
class Books_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
		
	public function list_books() {
		$query = $this->db->get('books');
		return $query->result_array();
	}
	
	public function issue_book($data) {
        return $this->db->insert('books_allocations',$data);  
    }
	
	public function book_allocation_count($book_id) {
		$where = "book_id = $book_id AND return_date IS NULL";
		$this->db->where($where);
		$this->db->from('books_allocations');
		return $this->db->count_all_results();
	}
	
	public function get_allocated_book($book_id){
		$where = "book_id = $book_id AND return_date IS NULL";
		$this->db->where($where);
		$query = $this->db->get('books_allocations');
		return $query->row();
	}
	
	public function return_book($data) {
		$where = 'book_id = '. $data['book_id'] .' AND return_date IS NULL';
		$this->db->where($where);
        return $this->db->update('books_allocations', array('return_date' => $data['return_date']));  
    }
}