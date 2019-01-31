<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    /**
    * Home construct
    *
    * Enable profiler is optional and only considered in developer mode.
    */
   function __construct() {
       parent::__construct();
       $this->load->model('Home_model');
       // $this->output->enable_profiler(TRUE);
       // If your controller have form_validation
       // $this->form_validation->CI =& $this;
   }

    /**
     * Index Page for this controller.
     *
     */
    public function index() {
        //Header data
        //Page Title
        $header['title'] = 'Move Away!';

        $data['headings'] = $this->Home_model->get_headings();
        $data['subheadings'] = $this->Home_model->get_subheadings();
        $data['products'] = $this->Home_model->get_all_products();
        $data['infos'] = $this->Home_model->get_product_infos();

        //Footer data
        $footer['title'] = '';

        $this->load->view('layouts/header', $header);
        $this->load->view('home', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function get_sum($product_id = NULL, $col = NULL) {
        if($product_id != NULL)
            return $this->Home_model->get_sum_of_col($product_id,$col);
        else
            return 'No Product Found!';
    }

    /**
     * When you are extending the table to the right
     * You need to add a heading and subheading
     * (let's assume there's 3) number of column
     * for each products (let's assume there's 12)
     * to your table (so you need to add 1 heading
     * and 3 columns for each 12 products)
     */
    public function insert_heading_info() {
        $this->db->trans_start();
        // Insert into headings
        $max = (int) $this->db->select_max('id')->from('headings')->get()->row()->id+1;
        $data = array(
            'id' => $max,
            'title' => 'A'.$max
        );
        $result = $this->Home_model->insert_heading($data);

        // Insert into informations2
        $products = $this->Home_model->get_all_products();
        if($products) {
            $subheadings = $this->Home_model->get_subheadings();

            $temp = $col = (int) $this->db->select_max('col')->from('informations2')->get()->row()->col+1;
            $data = array();
            foreach($products as $product) {
                foreach($subheadings as $subheading) {
                    array_push($data,array('product_id' => $product->id,'col' => $col++,'value' => 0));
                }
                $col = $temp;
            }
            $info = $this->Home_model->insert_info($data);
        }
        $this->db->trans_complete();
            
        if ($this->db->trans_status() === FALSE) {
            echo 'Transaction-error';
        }
        // else return $info;
        else redirect('/','location');
    }

    /**
     * Will Add POST Method Later.
     */
    public function insert_product($title = 'Product Z', $quantity = '456773221') {
        $this->db->trans_start();
        // Insert into Product
        $data = array(
            'title' => $title,
            'quantity' => $quantity
        );
        $product_id = $this->Home_model->insert($data);
        
        $headings = $this->Home_model->get_headings();
        if($headings) {
            $subheadings = $this->Home_model->get_subheadings();
            
            // Insert into informations
            $col = 1;
            $data = array();
            foreach($headings as $heading) {
                foreach($subheadings as $subheading) {
                    array_push($data,array('product_id' => $product_id,'col' => $col++,'value' => 0));
                }
            }
            $info = $this->Home_model->insert_info($data);
        }
        $this->db->trans_complete();
            
        if ($this->db->trans_status() === FALSE) {
            echo 'Transaction-error';
        }
        // else return $info;
        else redirect('/','location');
    }

    /**
     * Update informations2 value where product id and column matched.
     */
    public function update_info2() {
        $data = array(
            'value' => (int) $this->input->post('value')
        );
        $result = $this->Home_model->update($this->input->post('product_id'),(int) $this->input->post('column'),$data);
        echo json_encode($result);
    }

    /**
     * Reset rows in 1 click
     */
    public function reset($product_id = NULL) {
        if($product_id != NULL) {
            $result = $this->Home_model->reset($product_id);
            if($result)
                redirect('/','location');
            else
                echo 'Product Not Found!';
        }
    }

    /**
     * Delete Product
     */
    public function delete($product_id = NULL) {
        if($product_id != NULL) {
            $result = $this->Home_model->delete_product($product_id);
            if($result)
                redirect('/','location');
            else
                echo 'Product Not Found!';
        }
    }

    public function delete_heading($heading_id = NULL) {
        if($heading_id != NULL) {
            $n = $heading_id*3;
            for($i = $n; $i>$n-3; $i--)
                $result = $this->Home_model->delete_info($i);
            
            $result = $this->Home_model->delete_heading($heading_id);
            
            // Just to organize
            $result = $this->Home_model->shrink_heading($heading_id);
            $result = $this->Home_model->shrink_info($n);
            
            if($result)
                redirect('/','location');
            else
                echo 'Heading Not Found!';
        }
        else {
            echo 'Heading Not Found!';
        }
    }

    /**
	 * Search Functionality
	 * @param
	 * @return
	*/
	public function product_lookup() {
		$data = array(
			//'title' => $this->input->get('term'),
			'quantity' => $this->input->get('term')
		);
		$query = $this->db->select('id')->from('products')->where($data)->get();
        
        echo $query->num_rows()>0 ? json_encode($query->result()) : 0;
    }
    
    /**
	 * CHANGE_POSITION Functionality
	 *
	 * Sorts the table
	 *
	 * @param $id is product_id @products
	 * @return elapsed time || 0
	*/
	public function change_position($id = NULL) {
		if($id != NULL) {
            $max = (int) $this->db->select_max('id')->from('products')->get()->row()->id;
            if($id != $max) {
                $this->db->set('id', $max+1, FALSE);
			    $this->db->where('id', $id);
			    $this->db->update('products');
                $this->benchmark->mark('end');
                echo $this->db->count_all('products');
            }
            else echo -1;
            //else echo $max;
		}
		else echo 0;
	}

}
